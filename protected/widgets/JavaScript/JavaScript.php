<?php
/**
 * class Facebook
 * @author Igor Ivanović 
 */
class JavaScript extends CWidget{

    public $appId = '99999';
    public $status = true;
    public $cookie = true;
    public $xfbml  = true;
    public $oauth  = true;
    public $userSession = '5555';
    public $facebookButtonTitle = "Facebook Connect";
    public $fbLoginButtonId     = "fb_login_button";
    public $logoutButtonId      = "your_logout_button_id";
    public $facebookLoginUrl    = "facebook/login";
    public $facebookPermissions = "email,user_likes";
    public $facebookScriptFile  = "/facebook.js";
    public $script              = "/login.js";
    public $plugin              = "login-button";
    public $userId              = '';
    public $accessToken         = '';
    /**
    * Run Widget
    */
    public function run()
    {

        $this->facebookLoginUrl     = Yii::app()->createAbsoluteUrl($this->facebookLoginUrl);
        $assetUrl = Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('application.widgets.JavaScript.assets'));
        $this->facebookScriptFile   = $assetUrl.$this->facebookScriptFile;
        $this->userSession          = Yii::app()->session->sessionID;
        $this->renderJavascript();
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
        if(Yii::app()->user->id){
            $this->userId = Yii::app()->user->id;
            $this->accessToken = Yii::app()->facebook->getAccessToken();

            $script.=<<<EOL

            var userId = {$this->userId};
            var accessToken = '{$this->accessToken}';
EOL;

        }



        Yii::app()->clientScript->registerScript('facebook-connect',$script,  CClientScript::POS_END );
        // Yii::app()->clientScript->registerScriptFile($this->facebookScriptFile, CClientScript::POS_END);
        Yii::app()->clientScript->registerScriptFile("js/main.js", CClientScript::POS_END);
    }
}
