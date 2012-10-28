<?php
/**
 * class FacebookController
 * @author Igor Ivanović
 * Used to controll facebook login system 
 */
class FacebookController extends Controller
{

    private function curl_get_file_contents($URL) {
        $c = curl_init();
        curl_setopt($c, CURLOPT_RETURNTRANSFER, 1    );
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($c, CURLOPT_URL           , $URL );
        $contents = curl_exec($c);
        $err = curl_getinfo($c, CURLINFO_HTTP_CODE);
        curl_close($c);
        return $contents ?$contents :FALSE;
    }

    /*private function getAccessToken($logout) {
        $logout_url = parse_url($logout);
        parse_str(htmlspecialchars_decode($logout_url['query']), $logout_params);
        return $logout_params['access_token'];
    }*/

    private function getAccessTokenResponse($access_token) {
        # https://developers.facebook.com/blog/post/500/
        $graph_url = "https://graph.facebook.com/me?access_token=$access_token";
        $response  = $this->curl_get_file_contents($graph_url);
        return json_decode($response);
    }


    /**
     * This method authenticate logged in facebook user 
     * @param type $id string(int)
     * @param type $name string
     * @param type $surname string
     * @param type $username string
     * @param type $email string
     * @param type $session string
     */
    public function actionLogin( $id = null , $link = null, $name = null , $surname = null,$username = null, $email = null, $session = null, $access_token = null ){
        if( !Yii::app()->request->isAjaxRequest ){
            echo json_encode(array('error'=>'this is not ajax request'));
            die();
        } 
        else {
            if( empty($email) ){
                echo json_encode(array('error'=>'email is not provided'));
                die();
            }
            if( $session == Yii::app()->session->sessionID ){
                
                $decoded_response = $this->getAccessTokenResponse($access_token);

                if(($decoded_response->error)||
                    ($decoded_response->username != $username)||
                    ($decoded_response->id != $id)){

                    echo json_encode(array('error'=>'access token not match: '.print_r($decoded_response, true)));
                    die();
                }else{

                    $user = User::prepareUserForAuthorisation( $email );
                    if( $user === null ) {

                        $user                   = new User();
                        $user->correo           = $email;    
                        $user->nombre           = $name;
                        $user->apellido         = $surname;
                        $user->usuario          = $username;
                        $user->facebook_url     = $link;
                        $user->facebook_id      = $id;
                        $user->password         = $user->createRandomUsername();
                        $user->facebook_cuenta  = 1;
                        $user->insert();
                        echo json_encode( array( 'error'=>0, 'redirect'=> $this->createUrl('site/register',  array('user' => $user->id ) )) );
                        
                        die();
                    }
                    
                    $identity = new UserIdentity( $user->correo , $user->password );
                    $identity->authenticate();

      
                    if($identity->errorCode === UserIdentity::ERROR_NONE) {
                           Yii::app()->user->login($identity, NULL);
                           echo json_encode( array( 'error'=>0, 'redirect'=> $this->createUrl('site/index') ) );
                    } 
                    else {
                           echo json_encode(array('error'=>'user not logged in'));
                           die();
                    }

                }
            }
            else
            {
                echo json_encode(array('error'=>'session id is not the same'));
                die();
            }
        }
    }
}