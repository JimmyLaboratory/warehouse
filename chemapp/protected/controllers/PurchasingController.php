<?php

class PurchasingController extends Controller
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
                        array('allow',
                                'actions'=>array('apply'),
                                'roles'=>array('teacher')),
                        array('allow',
                                'actions'=>array('approve'),
                                'roles'=>array('college','secure','school')),
                        array('allow',
                                'actions'=>array('admin','view','print'),
                                'roles'=>array('college','secure','school','teacher')
                        ),
                        array('allow',
                                'actions'=>array('delete'),
                                'roles'=>array('teacher')
                        ),
                        array('allow',
                                'actions'=>array('cancel','topurchase','toachieve','purchasePrint','no'),
                                'roles'=>array('school')
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
                $this -> layout = '//layouts/column0';
                $this->render('print',array(
			'model'=>$this->loadModel($id),
		));
        }
        
        public function actionToachieve(){
                $ids = isset($_POST['ids']) ? $_POST['ids'] : '';
                if(empty($ids)) throw new CHttpException('400','你没有选择任何采购单哦。');
                $model = new Purchasing;
  
                if(isset($_GET['confirm']) && $_GET['confirm'] == 'true'){
                        $criteria = new CDbCriteria;
                        $criteria ->addInCondition('purchasing_id', explode(',',$ids));
                        $criteria ->addInCondition('status', array(Purchasing::STATUS_PASS_FINAL , Purchasing::STATUS_PURCHASING));
                        $result = Purchasing::model() ->findAll($criteria);
                        $achieve_info = array();
                        foreach($result as $r):
                                $achieve_info[] = array(
                                    'purchasing_id'=>$r->purchasing_id,
                                    'chem_name'=>$r->chemlist->chem_name,
                                    'quality'=>$r->chemlist->quality_id != -1 ? $r->chemlist->quality->quality_name : $r->chemlist->quality_other,
                                    'unit'=>$r->chemlist->unit_package.$r->chemlist->unit->unit_name,
                                    'nums'=>$r->chemlist->nums,
                                    'useway'=>Chemlist::getUsewayOptions($r->chemlist->useway),
                                    'note'=>$r->chemlist->note
                                );
                        endforeach;
                        $achieveModel = new Achieve;
                        $achieveModel -> achieve_id = $_POST['avhieve_id'];
                        $achieveModel -> timestamp = time();
                        $achieveModel -> achiever = $_POST['achiever'];
                        $achieveModel -> achieve_info = json_encode($achieve_info);
                        $achieveModel -> note = $_POST['note'];
                        if($achieveModel -> save())
                                $this->redirect(array('achieve/view','id'=>  $achieveModel->achieve_id));
                }
                
                $this->render('toachieve',array(
                        'ids'=>$ids,
			'model'=>$model,
		));
        }
        
        public function actionTopurchase(){
                $ids = isset($_POST['ids']) ? $_POST['ids'] : '';
                if(empty($ids)) throw new CHttpException('400','你没有选择任何采购单哦。');
                $model = new Purchasing;
                
                if(isset($_GET['confirm']) && $_GET['confirm'] == 'true'){
                        $criteria = new CDbCriteria;
                        $criteria ->addInCondition('purchasing_id', explode(',',$ids));
                        $criteria ->compare('status', Purchasing::STATUS_PASS_FINAL);
                        Purchasing::model() ->updateAll(array('status'=>  Purchasing::STATUS_PURCHASING, 'purchasing_no'=>$_POST['purchasing_no']),$criteria);
                        $this->redirect(array('purchasing/admin','Purchasing[status]'=>  Purchasing::STATUS_PURCHASING));
                }
                
                $this->render('topurchase',array(
                        'ids'=>$ids,
			'model'=>$model,
		));
        }
        
        public function actionNo()
	{
		
                $datas = Yii::app() -> db ->createCommand('SELECT DISTINCT  `purchasing_no` FROM  `purchasing` WHERE status = 10')
                                        ->queryAll();
                
		$this->render('no',array(
			'datas'=>$datas,
		));
	}
        
        public function actionPurchasePrint(){
                $this -> layout = '//layouts/column0';
                $no = isset($_GET['no']) ? $_GET['no'] : '';
                
                $model = new Purchasing;
                
                $this->render('purchase_print',array(
                        'no'=>$no,
			'model'=>$model,
		));
        }
        
        public function actionCancel($id){
                $model = $this->loadModel($id);
                if($model->status != Purchasing::STATUS_PASS_FINAL && $model->status != Purchasing::STATUS_PURCHASING)
                        throw new CHttpException(403,'采购单当前状态不允许取消采购');
                $information = json_decode($model->information, true);
                $information[] = '学校【'.$_POST['Purchasing']['person'].'】于'.date('Y-m-d H:i:s').'取消采购申请，理由'.$_POST['Purchasing']['reason'];
                $model->information = json_encode($information);
                $model->status = Purchasing::STATUS_REJECT;
                $model->save();
                $this->redirect(array('view','id'=>$model->purchasing_id));
        }
        
        public function actionApprove($id){
                $model = $this->loadModel($id);
                
                if(isset($_POST['Purchasing']))
		{
                        $userInfo = User::getInfo();
			if(($model->status == Purchasing::STATUS_APPLY && Yii::app() -> authManager -> checkAccess('college',Yii::app()->user->getId()))){
                                if($model->user->department_id != $userInfo->department_id) return false;
                                if($_POST['Purchasing']['approve'] == '1'){
                                        $model -> status = Purchasing::STATUS_PASS_FIRST;
                                        $information = json_decode($model -> information,true);
                                        $information[] = '学院【'.$userInfo->realname.'】于'.date('Y-m-d H:i:s').'同意该申请';
                                        if(!empty($_POST['Purchasing']['person1']))
                                                $information[] = '学院审批人'.$_POST['Purchasing']['person1'].'意见：'.$_POST['Purchasing']['reason1'];
                                        if(!empty($_POST['Purchasing']['person2']))
                                                $information[] = '学院审批人'.$_POST['Purchasing']['person2'].'意见：'.$_POST['Purchasing']['reason2'];
                                        if(!empty($_POST['Purchasing']['person3']))
                                                $information[] = '学院审批人'.$_POST['Purchasing']['person3'].'意见：'.$_POST['Purchasing']['reason3'];
                                        $model->information = json_encode($information);
                                        $model->save();
                                }
                                if($_POST['Purchasing']['approve'] == '-1'){
                                        $model -> status = Purchasing::STATUS_REJECT;
                                        $information = json_decode($model -> information,true);
                                        $information[] = '学院【'.$userInfo->realname.'】于'.date('Y-m-d H:i:s').'拒绝该申请';
                                        if(!empty($_POST['Purchasing']['person1']))
                                                $information[] = '学院审批人'.$_POST['Purchasing']['person1'].'意见：'.$_POST['Purchasing']['reason1'];
                                        if(!empty($_POST['Purchasing']['person2']))
                                                $information[] = '学院审批人'.$_POST['Purchasing']['person2'].'意见：'.$_POST['Purchasing']['reason2'];
                                        if(!empty($_POST['Purchasing']['person3']))
                                                $information[] = '学院审批人'.$_POST['Purchasing']['person3'].'意见：'.$_POST['Purchasing']['reason3'];
                                        $model->information = json_encode($information);
                                        $model->save();
                                }
                        }
                        
                        if( ($model->status == Purchasing::STATUS_PASS_FIRST || $model->status == Purchasing::STATUS_PASS_SCHOOL) && Yii::app() -> authManager -> checkAccess('secure',Yii::app()->user->getId())){
                                if($_POST['Purchasing']['approve'] == '1'){
                                        $model -> status = $model->status == Purchasing::STATUS_PASS_SCHOOL ? Purchasing::STATUS_PASS_FINAL : Purchasing::STATUS_PASS_SECURE;
                                        $information = json_decode($model -> information,true);
                                        $information[] = '保卫处【'.$userInfo->realname.'】于'.date('Y-m-d H:i:s').'同意该申请';
                                        if(!empty($_POST['Purchasing']['person1']))
                                                $information[] = '保卫处审批人'.$_POST['Purchasing']['person1'].'意见：'.$_POST['Purchasing']['reason1'];
                                        if(!empty($_POST['Purchasing']['person2']))
                                                $information[] = '保卫处审批人'.$_POST['Purchasing']['person2'].'意见：'.$_POST['Purchasing']['reason2'];
                                        if(!empty($_POST['Purchasing']['person3']))
                                                $information[] = '保卫处审批人'.$_POST['Purchasing']['person3'].'意见：'.$_POST['Purchasing']['reason3'];
                                        $model->information = json_encode($information);
                                        $model->save();
                                }
                                if($_POST['Purchasing']['approve'] == '-1'){
                                        $model -> status = Purchasing::STATUS_REJECT;
                                        $information = json_decode($model -> information,true);
                                        $information[] = '保卫处【'.$userInfo->realname.'】于'.date('Y-m-d H:i:s').'拒绝该申请';
                                        if(!empty($_POST['Purchasing']['person1']))
                                                $information[] = '保卫处审批人'.$_POST['Purchasing']['person1'].'意见：'.$_POST['Purchasing']['reason1'];
                                        if(!empty($_POST['Purchasing']['person2']))
                                                $information[] = '保卫处审批人'.$_POST['Purchasing']['person2'].'意见：'.$_POST['Purchasing']['reason2'];
                                        if(!empty($_POST['Purchasing']['person3']))
                                                $information[] = '保卫处审批人'.$_POST['Purchasing']['person3'].'意见：'.$_POST['Purchasing']['reason3'];
                                        $model->information = json_encode($information);
                                        $model->save();
                                }
                        }
                        
                        if( ($model->status == Purchasing::STATUS_PASS_FIRST || $model->status == Purchasing::STATUS_PASS_SECURE) && Yii::app() -> authManager -> checkAccess('school',Yii::app()->user->getId())){
                                if($_POST['Purchasing']['approve'] == '1'){
                                        $model -> status = $model->status == Purchasing::STATUS_PASS_SECURE ? Purchasing::STATUS_PASS_FINAL : Purchasing::STATUS_PASS_SCHOOL;
                                        $information = json_decode($model -> information,true);
                                        $information[] = '学校【'.$userInfo->realname.'】于'.date('Y-m-d H:i:s').'同意该申请';
                                        if(!empty($_POST['Purchasing']['person1']))
                                                $information[] = '学校审批人'.$_POST['Purchasing']['person1'].'意见：'.$_POST['Purchasing']['reason1'];
                                        if(!empty($_POST['Purchasing']['person2']))
                                                $information[] = '学校审批人'.$_POST['Purchasing']['person2'].'意见：'.$_POST['Purchasing']['reason2'];
                                        if(!empty($_POST['Purchasing']['person3']))
                                                $information[] = '学校审批人'.$_POST['Purchasing']['person3'].'意见：'.$_POST['Purchasing']['reason3'];
                                        $model->information = json_encode($information);
                                        $model->save();
                                }
                                if($_POST['Purchasing']['approve'] == '-1'){
                                        $model -> status = Purchasing::STATUS_REJECT;
                                        $information = json_decode($model -> information,true);
                                        $information[] = '学校【'.$userInfo->realname.'】于'.date('Y-m-d H:i:s').'拒绝该申请';
                                        if(!empty($_POST['Purchasing']['person1']))
                                                $information[] = '学校审批人'.$_POST['Purchasing']['person1'].'意见：'.$_POST['Purchasing']['reason1'];
                                        if(!empty($_POST['Purchasing']['person2']))
                                                $information[] = '学校审批人'.$_POST['Purchasing']['person2'].'意见：'.$_POST['Purchasing']['reason2'];
                                        if(!empty($_POST['Purchasing']['person3']))
                                                $information[] = '学校审批人'.$_POST['Purchasing']['person3'].'意见：'.$_POST['Purchasing']['reason3'];
                                        $model->information = json_encode($information);
                                        $model->save();
                                }
                        }
		}
                
                if($model -> status == Purchasing::STATUS_PASS_FINAL){
                        $chemModel = Chemlist::model()->findByPk($model->chem_id);
                        $chemModel -> status = Chemlist::STATUS_APPROVE;
                        $chemModel -> save();
                }
                if($model -> status == Purchasing::STATUS_REJECT){
                        $chemModel = Chemlist::model()->findByPk($model->chem_id);
                        $chemModel -> status = Chemlist::STATUS_REJECT;
                        $chemModel -> save();
                }
                
                $this->redirect(array('view','id'=>$model->purchasing_id));
        }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Purchasing;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Purchasing']))
		{
			$model->attributes=$_POST['Purchasing'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->purchasing_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
        
        public function actionApply()
	{
		$model=new Chemlist;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Chemlist']))
		{
			$model->attributes=$_POST['Chemlist'];
                        $model->production_date = date('Y-m-d');
                        $userInfo = User::getInfo();
                        $model->user_id = $userInfo -> user_id;//注入用户ID
                        $model->status = Purchasing::STATUS_APPLY;
			if($model->save())
                        {
                                $model2=new Purchasing;
                                $model2->purchasing_id = $_POST['Chemlist']['purchasing_id'];
                                $model2->chem_id = $model->chem_id;
                                $model2->user_id = $model->user_id;
                                $model2->timestamp = time();
                                $model2->status = Chemlist::STATUS_APPLY;
                                $information = array('教师：'.$userInfo->user_name.'【'.$userInfo->realname.'】于'.date('Y-m-d H:i:s').'提交采购申请表');
                                $model2->information = json_encode($information);
                                if($model2->save()){
                                        $this->redirect(array('view','id'=>$model2->purchasing_id));
                                }
                        }
		}

		$this->render('apply',array(
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

		if(isset($_POST['Purchasing']))
		{
			$model->attributes=$_POST['Purchasing'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->purchasing_id));
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
		$dataProvider=new CActiveDataProvider('Purchasing');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Purchasing('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Purchasing']))
			$model->attributes=$_GET['Purchasing'];

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
		$model=Purchasing::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='purchasing-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
