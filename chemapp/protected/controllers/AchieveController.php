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
				'actions'=>array('admin','view','print','begin','create','update'),
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
	public function actionAdmin()			//这个主要查看各个状态的备案
	{
		$model=new Achieve('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Achieve']))
			$model->attributes=$_GET['Achieve'];

		$this->render('admin',array(
			'model'=>$model,'status'=>isset($_GET['status'])? $_GET['status']:Achieve::STATUS_SENDING
		));
	}

	public function actionBegin()			//这个是"开始备案"的控制器,从采购类那把"全审通过的申请"拿来显示
	{
		$model=new Purchasing('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Purchasing']))
			$model->attributes=$_GET['Purchasing'];

		$this->render('begin',array(
			'model'=>$model,
		));
	}

	public function actionCreate()			//新建备案,参数为采购单ID,填入备案信息,提交
	{
		$model=new Achieve('search');
		$purchasing=Purchasing::model()->findByPk($_GET['pid']);	//获得采购单对象
		$chemlist=Chemlist::model()->findByPk($purchasing->chem_id);	//获得化学品对象

		$info['chem_name']=$chemlist->chem_name;						//整理药品信息来打印出来
		//$info['quality']=$chemlist->chem_quality;						可参考PurchasingController.php
		$info['quality']=$chemlist->quality_id != -1 ? $chemlist->quality->quality_name : $chemlist->quality_other;
		//$info['unit']=$chemlist->unit;						//中的actionToAchieve
		$info['unit']=$chemlist->unit_package.$chemlist->unit->unit_name;
		$info['nums']=$chemlist->nums;

		if(isset($_POST['Achieve'])){
			$model->attributes=$_POST['Achieve'];
			$model->achieve_info = json_encode($info);
			$model->timestamp=time();
			if($purchasing===null)
				throw new CHttpException(404,'The requested page does not exist.');
			if($model->save()){
				$purchasing->status=Purchasing::STATUS_ARCHIVES;
				$purchasing->save();
				$this->redirect(array('print','id'=>$model->id));//提交完成后直接转到打印页面
			}
		}
		$model->purchasing_id=$purchasing->purchasing_id;
		
		$this->render('create',array(
			'model'=>$model,'purchasing'=>$chemlist
		));
	}
        
    public function actionPrint($id){			//打印备案单
        $this->layout = '//layouts/column0';
        $this->render('print',array(
		'model'=>$this->loadModel($id),
	));
    }

	public function actionUpdate($id)				//修改备案中的备案单,成功则添加备案号,或者改变状态为备案失败
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Achieve']))
		{
			$model->attributes=$_POST['Achieve'];
			if($model->save())
				$this->redirect(array('admin'));
		}
		$this->render('update',array(
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
