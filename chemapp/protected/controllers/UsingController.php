<?php

class UsingController extends Controller
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
				'actions'=>array('index','view','create','admin','print'),
				'roles'=>array('teacher','college','school'),
			),
                        array('allow',
                                'actions'=>array('approve'),
                                'roles'=>array('college','school')
                        ),
                        array('allow',
                                'actions'=>array('delete'),
                                'roles'=>array('teacher')
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
        
        public function actionPrint($id)
        {
                $this->layout = '//layouts/column0';
                $this->render('print',array(
			'model'=>$this->loadModel($id),
		));
        }

        public function actionApprove($id){
                $model = $this->loadModel($id);
                
                if(isset($_POST['Using']))
		{
                        $userInfo = User::getInfo();
			if(($model->status == Using::STATUS_APPLY && Yii::app() -> authManager -> checkAccess('college',Yii::app()->user->getId()))){
                                if($model->user->department_id != $userInfo->department_id) return false;
                                if($_POST['Using']['approve'] == '1'){
                                        $model -> status = Using::STATUS_APPROVE_FIRST;
                                        $information = json_decode($model -> information,true);
                                        $information[] = '学院【'.$userInfo->realname.'】于'.date('Y-m-d H:i:s').'同意该申请';
                                        if(!empty($_POST['Purchasing']['person1']))
                                                $information[] = '学院审批人'.$_POST['Using']['person1'].'意见：'.$_POST['Using']['reason1'];
                                        if(!empty($_POST['Purchasing']['person2']))
                                                $information[] = '学院审批人'.$_POST['Using']['person2'].'意见：'.$_POST['Using']['reason2'];
                                        if(!empty($_POST['Purchasing']['person3']))
                                                $information[] = '学院审批人'.$_POST['Using']['person3'].'意见：'.$_POST['Using']['reason3'];
                                        $model->information = json_encode($information);
                                        $model->save();
                                }
                                if($_POST['Using']['approve'] == '-1'){
                                        $model -> status = Using::STATUS_REJECT;
                                        $information = json_decode($model -> information,true);
                                        $information[] = '学院【'.$userInfo->realname.'】于'.date('Y-m-d H:i:s').'拒绝该申请';
                                        if(!empty($_POST['Purchasing']['person1']))
                                                $information[] = '学院审批人'.$_POST['Using']['person1'].'意见：'.$_POST['Using']['reason1'];
                                        if(!empty($_POST['Purchasing']['person2']))
                                                $information[] = '学院审批人'.$_POST['Using']['person2'].'意见：'.$_POST['Using']['reason2'];
                                        if(!empty($_POST['Purchasing']['person3']))
                                                $information[] = '学院审批人'.$_POST['Using']['person3'].'意见：'.$_POST['Using']['reason3'];
                                        $model->information = json_encode($information);
                                        $model->save();
                                }
                        }
                        
                        if( $model->status == Using::STATUS_APPROVE_FIRST && Yii::app() -> authManager -> checkAccess('school',Yii::app()->user->getId())){
                                if($_POST['Using']['approve'] == '1'){
                                        $model -> status = Using::STATUS_APPROVE_FINAL;
                                        $information = json_decode($model -> information,true);
                                        $information[] = '学校【'.$userInfo->realname.'】于'.date('Y-m-d H:i:s').'同意该申请';
                                        if(!empty($_POST['Purchasing']['person1']))
                                                $information[] = '学校审批人'.$_POST['Using']['person1'].'意见：'.$_POST['Using']['reason1'];
                                        if(!empty($_POST['Purchasing']['person2']))
                                                $information[] = '学校审批人'.$_POST['Using']['person2'].'意见：'.$_POST['Using']['reason2'];
                                        if(!empty($_POST['Purchasing']['person3']))
                                                $information[] = '学校审批人'.$_POST['Using']['person3'].'意见：'.$_POST['Using']['reason3'];
                                        $model->information = json_encode($information);
                                        $model->save();
                                }
                                if($_POST['Using']['approve'] == '-1'){
                                        $model -> status = Using::STATUS_REJECT;
                                        $information = json_decode($model -> information,true);
                                        $information[] = '学校【'.$userInfo->realname.'】于'.date('Y-m-d H:i:s').'拒绝该申请';
                                        if(!empty($_POST['Purchasing']['person1']))
                                                $information[] = '学校审批人'.$_POST['Using']['person1'].'意见：'.$_POST['Using']['reason1'];
                                        if(!empty($_POST['Purchasing']['person2']))
                                                $information[] = '学校审批人'.$_POST['Using']['person2'].'意见：'.$_POST['Using']['reason2'];
                                        if(!empty($_POST['Purchasing']['person3']))
                                                $information[] = '学校审批人'.$_POST['Using']['person3'].'意见：'.$_POST['Using']['reason3'];
                                        $model->information = json_encode($information);
                                        $model->save();
                                }
                        }
		}
                
                $this->redirect(array('view','id'=>$model->using_id));
        }
        
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Using;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Using']))
		{
                        $userInfo = User::getInfo();
                        $chemInfo = Chemlist::model()->findByPk($_POST['Using']['chem_id']);
                        if($chemInfo->user_id != $userInfo->user_id) throw new CHttpException(403,'Invalid request.');
			$model->attributes=$_POST['Using'];
                        $model->status = Using::STATUS_APPLY;
                        $model->user_id = $userInfo->user_id;
                        $model->timestamp = time();
                        $information = array('教师：'.$userInfo->user_name.'【'.$userInfo->realname.'】于'.date('Y-m-d H:i:s').'提交使用申请表');
                        $model->information = json_encode($information);
			if($model->save())
				$this->redirect(array('view','id'=>$model->using_id));
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

		if(isset($_POST['Using']))
		{
			$model->attributes=$_POST['Using'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->using));
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
		$dataProvider=new CActiveDataProvider('Using');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Using('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Using']))
			$model->attributes=$_GET['Using'];

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
		$model=Using::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='using-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
