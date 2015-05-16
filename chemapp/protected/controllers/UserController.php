<?php

class UserController extends Controller
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
				'actions'=>array('index','create','admin'),
				'roles'=>array('school','college'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('view','update','passwd'),
				'roles'=>array('school','secure','college','teacher'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'roles'=>array('school','college'),
			),
			array('deny',  // deny all users
				'users'=>array('*')
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
                $model=$this->loadModel($id);
                //校验角色权限
               /* if(Yii::app() -> authManager -> checkAccess('college',Yii::app()->user->getId())){
                        $userInfo = User::getUserInfo();
                        //if($model->department_id != $userInfo->department_id || ($model->user_role != 'teacher' && $model->user_role != 'college')) throw new CHttpException(403,'查看用户的检验角色权限出错，需要学院权限.');
                }
                elseif(Yii::app() -> authManager -> checkAccess('teacher',Yii::app()->user->getId())){
                        if($model->user_name != Yii::app()->user->getId()) throw new CHttpException(403,'查看用户的检验角色权限出错，需要教师权限.');
                }
                else{
                        
                }*/
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new User;

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			
			$model->attributes=$_POST['User'];
			$pUser=User::getInfo(); 
			$model->department_id=$pUser->user_id;
//			$model->dname=$pUser->dname;
			if($model->save())
				$this->redirect(array('view','id'=>$model->user_id));
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
		//校验角色权限
		if($model->user_name == Yii::app()->user->getId()){
				if(isset($_POST['User']['lock'])) unset($_POST['User']['lock']);//TJ：不知道师兄写这个有什么意义
				if(isset($_POST['User']['user_role'])) unset($_POST['User']['user_role']);
				if(isset($_POST['User']['department_id'])) unset($_POST['User']['department_id']);
		}
		elseif(Yii::app() -> authManager -> checkAccess('college',Yii::app()->user->getId())){
				$userInfo = User::getInfo();
				if($model->department_id != $userInfo->user_id)
					throw new CHttpException(403,'actionUpdate检验权限错误(学校用户应该不用修改非本学院用户信息).');
				if($model->user_role != 'teacher' ) 
					throw new CHttpException(403,'actionUpdate检验权限错误(学院用户不能修改非教师用户信息).');
		} 
		elseif(Yii::app() -> authManager -> checkAccess('school',Yii::app()->user->getId())){
				$userInfo = User::getInfo();
				if($model->department_id != $userInfo->user_id)
					throw new CHttpException(403,'actionUpdate检验权限错误(学校用户应该不用修改教师用户信息).');
		} 
                
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->user_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
        
        public function actionPasswd($id)
        {
                $model=$this->loadModel($id);
                
                //校验角色权限
                if(Yii::app() -> authManager -> checkAccess('college',Yii::app()->user->getId())){
                        $userInfo = User::model() ->find('user_name=:user_name',array(':user_name'=>Yii::app()->user->getId()));
                        if($model->department_id != $userInfo->department_id || ($model->user_role != 'teacher' && $model->user_role != 'college')) throw new CHttpException(403,'Invalid request.');
                }
                elseif(Yii::app() -> authManager -> checkAccess('teacher',Yii::app()->user->getId())){
                        if($model->user_name != Yii::app()->user->getId()) throw new CHttpException(403,'Invalid request.');
                        if(isset($_POST['User']['lock'])) unset($_POST['User']['lock']);
                        if(isset($_POST['User']['user_role'])) unset($_POST['User']['user_role']);
                        if(isset($_POST['User']['department_id'])) unset($_POST['User']['department_id']);
                }
                else{
                        
                }
                
                if(isset($_POST['User']))
		{
                        if(md5($_POST['User']['old_password']) != $model->password)
                                $this->redirect(array('passwd','id'=>$model->user_id,'msg'=>'旧密码输入错误，请重新输入'));
                        $model -> password = $_POST['User']['new_password'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->user_id));
		}
                
                $this->render('passwd',array(
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
        $model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new User('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['User']))
			$model->attributes=$_GET['User'];

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
		$model=User::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
