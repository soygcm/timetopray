<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
	/*protected function afterRender($view, &$output) {
      parent::afterRender($view,$output);
      //Yii::app()->facebook->addJsCallback($js); // use this if you are registering any $js code you want to run asyc
      Yii::app()->facebook->initJs($output); // this initializes the Facebook JS SDK on all pages
      Yii::app()->facebook->renderOGMetaTags(); // this renders the OG tags
      return true;
    }*/
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}
/*
	public function actionLogin( $id = null , $name = null , $surname = null,$username = null, $email = null, $session = null )
    {
        if( !Yii::app()->request->isAjaxRequest )
        {
            echo json_encode(array('error'=>'this is not ajax request'));
            die();
        } 
        else 
        {
            if( empty($email) )
            {
                echo json_encode(array('error'=>'email is not provided'));
                die();
            }
            if( $session == Yii::app()->session->sessionID )
            {
            
                $user = User::prepareUserForAuthorisation( $email );
                
                if( $user === null ) 
                {
                    $user                   = new User();
                    $user->e_mail           = $email;    
                    $user->first_name       = $name;
                    $user->last_name        = $surname;
                    $user->username         = $username;
                    $user->password         = $user->createRandomUsername();
                    $user->facebook_account   = 1;
                    $user->insert();
                }
                
                $identity = new UserIdentity( $user->e_mail , $user->password );
                $identity->authenticate();

  
                if($identity->errorCode === UserIdentity::ERROR_NONE) 
                {
                       Yii::app()->user->login($identity, NULL);
                       echo json_encode( array( 'error'=>0, 'redirect'=> $this->createUrl('user/index') ) );
                } 
                else 
                {
                       echo json_encode(array('error'=>'user not logged in'));
                       die();
                }
            }
            else
            {
                echo json_encode(array('error'=>'session id is not the same'));
                die();
            }
        }
    }*/

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}