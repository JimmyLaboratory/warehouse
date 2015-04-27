<?php

class AchieveController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','view','print','begin','create'),
				'roles'=>array('school'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Achieve('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Achieve']))
			$model->attributes=$_GET['Achieve'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	public function actionBegin()
	{
		$model=new Purchasing('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Purchasing']))
			$model->attributes=$_GET['Purchasing'];

		$this->render('begin',array(
			'model'=>$model,
		));
	}

	public function actionCreate()
	{
		$model=new Achieve('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_POST['Achieve'])){
			$model->attributes=$_POST['Achieve'];
			if($model->save())
				$this->redirect(array('admin'));//,'id'=>$model->purchasing_id));
		}
		$this->render('create',array(
			'model'=>$model,'purchasing_id'=>$_GET['pid'],
		));
	}
        
    public function actionPrint($id){
            $this->layout = '//layouts/column0';
            $this->render('print',array(
		'model'=>$this->loadModel($id),
	));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Achieve::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='achieve-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
