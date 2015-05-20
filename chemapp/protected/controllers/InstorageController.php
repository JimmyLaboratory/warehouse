<?php

class InstorageController extends Controller
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
				'actions'=>array('index','view','create','admin','update','delete'),
				'roles'=>array('school','college'),
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
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Instorage;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Instorage']))
		{
			$model->attributes=$_POST['Instorage'];
			$userInfo = User::getInfo();
			$model->user_id = $userInfo->user_id;
			$image = CUploadedFile::getInstance($model, 'pics');		//获取图片信息
			if( is_object($image) && get_class($image) === 'CUploadedFile' ){  
					$model->pics = uniqid().'.jpg';  					//随机改名
					$image->saveAs(Yii::app()->basePath.'/../upload/'.$model->pics);  //保存到upload文件夹
			}else{  
					$model->pics = 'NoPic.jpg';  
			} 
			if($model->save()){
                $modelPurchasing = Purchasing::model() ->findByPk($model->purchasing_id);
                $modelChemlist = Chemlist::model() ->findByPk($modelPurchasing -> chem_id);
                $modelPurchasing -> status = Purchasing::STATUS_INSTOCK;
                $modelChemlist -> status = Chemlist::STATUS_INSTOCK;
                $modelChemlist -> storage_id = $model -> storage_id;
                $modelPurchasing -> save();
                $modelChemlist -> save();
				$this->redirect(array('view','id'=>$model->instorage_id));
            }
		}

		$this->render('create',array(
			'model'=>$model,
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

		if(isset($_POST['Outstorage']))
		{
			$model->attributes=$_POST['Outstorage'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->outstorage_id));
		}

		$this->render('update',array(
			'model'=>$model,
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Instorage');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Instorage('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Instorage']))
			$model->attributes=$_GET['Instorage'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Instorage::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='instorage-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
