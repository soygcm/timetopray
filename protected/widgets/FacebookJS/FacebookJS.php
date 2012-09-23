<?php
/**
 * class Facebook
 * @author Igor Ivanović 
 */
class Facebook extends CWidget{

    public $appId;
    public $status = true;
    public $cookie = true;
    public $xfbml  = true;
    public $oauth  = true;
    public $userSession;
    public $facebookButtonTitle = "Facebook Connect";
    public $fbLoginButtonId     = "fb_login_button_id";
    public $logoutButtonId      = "your_logout_button_id";
    public $facebookLoginUrl    = "facebook/login";
    public $facebookPermissions = "email,user_likes";
    public $facebookScriptFile  = "/facebook.js";
    /**
    * Run Widget
    */
    public function run()
    {
        // Fancybox stuff.
        /*$assetUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.fancybox.assets'));
        Yii::app()->clientScript->registerScriptFile($assetUrl.'/jquery.fancybox-1.3.4.pack.js'); 
        Yii::app()->clientScript->registerScriptFile($assetUrl.'/jquery.mousewheel-3.0.4.pack.js'); 
        */
        /*$facebook = new Facebook(array(
              'appId'  => '292898010730930',
              'secret' => '9d99741e688368fa6cfaa813b0d4eca0'
            ));

        // See if there is a user from a cookie
            $user = $facebook->getUser();

            print_r($user);


            if ($user) {
              try {
                // Proceed knowing you have a logged in user who's authenticated.
                $user_profile = $facebook->api('/me');
                echo "Name: " . $user_profile['name'];
              } catch (FacebookApiException $e) {
                echo 'FacebookApiException';
                echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
                $user = null;
              }

            }*/

        $this->facebookLoginUrl     = Yii::app()->createAbsoluteUrl($this->facebookLoginUrl);
        $assetUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.widgets.facebook.assets'));
        $this->facebookScriptFile   = $assetUrl.$this->facebookScriptFile;
        $this->userSession          = Yii::app()->session->sessionID;
        $this->renderJavascript();
        $this->render('login');
    }
    /**
    * Render necessary facebook  javascript
    */
    private function renderJavascript()
    {
        $script=<<<EOL

            var fbLoginButtonId = "{$this->fbLoginButtonId}";
            var facebookLoginUrl = '{$this->facebookLoginUrl}';
            var userSession = "{$this->userSession}";
            var facebookPermissions = '{$this->facebookPermissions}';
            var logoutButtonId = "{$this->logoutButtonId}";
            var appId  = '{$this->appId}';
            var status =  {$this->status};
            var cookie =  {$this->cookie};
            var xfbml  = {$this->xfbml};
            var oauth  = {$this->oauth};
EOL;

        Yii::app()->clientScript->registerScript('facebook-connect',$script,  CClientScript::POS_END );
        Yii::app()->clientScript->registerScriptFile($this->facebookScriptFile, CClientScript::POS_END);
    }
}
