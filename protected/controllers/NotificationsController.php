<?php
class NotificationsController extends Controller
{
	public function actionIndex()
	{	
		// echo "Error?";
		$this->render('index');

		
	}
	protected function afterRender($view, &$output)
	{
	    parent::afterRender($view,$output);
	    //Yii::app()->facebook->addJsCallback($js); // use this if you are registering any $js code you want to run asyc
	    Yii::app()->facebook->initJs($output); // this initializes the Facebook JS SDK on all pages
	    Yii::app()->facebook->renderOGMetaTags(); // this renders the OG tags

	    return true;
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}