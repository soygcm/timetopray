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
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		// echo "Hello";
		$this->render('index');
	}

	/**
     * Displays the register page
     */
    public function actionRegister()
    {
            $model=new RegisterForm;
            $newUser = new User;
            
            // if it is ajax validation request
            if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
            {
                    echo CActiveForm::validate($model);
                    Yii::app()->end();
            }

            // collect user input data
            if(isset($_POST['RegisterForm']))
            {
                    $model->attributes=$_POST['RegisterForm'];
                    $newUser->username = $model->username;
                    $newUser->password = $model->password;
                    $newUser->email = $model->email;
                    $newUser->joined = date('Y-m-d');
                            
                    if($newUser->save()) {
                            $identity=new UserIdentity($newUser->username,$model->password);
                            $identity->authenticate();
                            Yii::app()->user->login($identity,0);
                            //redirect the user to page he/she came from
                            $this->redirect(Yii::app()->user->returnUrl);
                    }
                            
            }
            // display the register form
            $this->render('register',array('model'=>$model));
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
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
	protected function afterRender($view, &$output)
	{
	    parent::afterRender($view,$output);
	    //Yii::app()->facebook->addJsCallback($js); // use this if you are registering any $js code you want to run asyc
	    Yii::app()->facebook->initJs($output); // this initializes the Facebook JS SDK on all pages
	    Yii::app()->facebook->renderOGMetaTags(); // this renders the OG tags



	    return true;
	}
	
}