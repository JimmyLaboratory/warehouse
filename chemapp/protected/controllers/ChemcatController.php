<?php

class ChemcatController extends Controller
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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update','admin','delete'),
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Chemcat']))
		{
			$model->attributes=$_POST['Chemcat'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->cat_id));
		}

		$this->render('update',array(
			'model'=>$model,'cur_parent_id'=>isset($_GET['cur_parent_id'])? $_GET['cur_parent_id']:'0'
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


	/**
	 * 管理药品分类页面
	 * 包括搜索/添加/删除/修改
	 */
	public function actionAdmin()
	{
		$model=new Chemcat('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_POST['Chemcat']))		//这是提交新的分类为数据库添加记录
		{
			$model->attributes=$_POST['Chemcat'];
			if($model->save())
				$this->redirect(array('admin','cur_parent_id'=>$_POST['Chemcat']['parent_id']));
		}
		else if(isset($_GET['Chemcat']))	//这是高级搜索的提交,和上面的提交绝不会同时发生
			$model->attributes=$_GET['Chemcat'];

		$this->render('admin',array(
			'model'=>$model,'cur_parent_id'=>isset($_GET['cur_parent_id'])? $_GET['cur_parent_id']:'0' ,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Chemcat::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='chemcat-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
