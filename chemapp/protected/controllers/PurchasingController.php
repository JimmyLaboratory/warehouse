<?php
/*TJ:采购管理控制器
	采购申请
	申请审批
	申请终止
	打印
	*/
class PurchasingController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $menu2=array();
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
	public function accessRules()			//TJ:执行各种行为的权限设置
	{
		return array(
            array('allow',
                    'actions'=>array('apply'),	//申请
                    'roles'=>array('teacher')),
            array('allow',
                    'actions'=>array('approve'),//审批
                    'roles'=>array('college','secure','school')),
            array('allow',
                    'actions'=>array('admin','view','print'),//管理，查看，打印
                    'roles'=>array('college','secure','school','teacher')
            ),
            array('allow',
                    'actions'=>array('delete'),//删除？还需要吗？做神马呀
                    'roles'=>array('teacher')
            ),
            array('allow',
                    'actions'=>array('cancel'),//终止
                    'roles'=>array('college')
            ),
            array('allow',
                    'actions'=>array('topurchase','toachieve','purchasePrint','no','cancel'),
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
    
	
	public function actionToachieve(){			//TJ:原备案功能
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
        
        public function actionCancel($id,$uid,$reason){
            //TJ:终止采购
                $model = $this->loadModel($id);       
                switch($model->status){
                    case Purchasing::STATUS_APPLY:;
                    case Purchasing::STATUS_PASS_FIRST:;
                    case Purchasing::STATUS_PASS_SECURE:;
                    case Purchasing::STATUS_PASS_SCHOOL:;
                    case Purchasing::STATUS_PASS_FINAL:break;
                    default:throw new CHttpException(403,'采购单当前状态不允许取消采购');
                }
                if(isset($_GET['reason'])){
                    $information = json_decode($model->information, true);
                    $information[] = '学院【'.$uid.'】于'.date('Y-m-d H:i:s').'终止采购申请，理由:'.$reason;
                    $model->information = json_encode($information);
                    $model->status = Purchasing::STATUS_CANCEL;
                    $model->save();
                    $this->redirect(array('view','id'=>$model->purchasing_id));
                }
        }

        private function getInformation($model,$userInfo,$department){
            //TJ:从审批页面获取审批信息,参数为部门,例如'学院''保卫处''学校'
            $information = json_decode($model -> information,true);
            if($_POST['Purchasing']['approve'] == '1'){
                $information[] = $department.'【'.$userInfo->realname.'】于'.date('Y-m-d H:i:s').'同意该申请';
            }
            else if($_POST['Purchasing']['approve'] == '-1'){
                $information[] = $department.'【'.$userInfo->realname.'】于'.date('Y-m-d H:i:s').'拒绝该申请';
            }
            if(!empty($_POST['Purchasing']['inputer']))
                    $information[] = $department.'录入人:'.$_POST['Purchasing']['inputer'];
            if(!empty($_POST['Purchasing']['person1']))
                    $information[] = $department.'审批人:'.$_POST['Purchasing']['person1'].' 意见：'.$_POST['Purchasing']['reason1'];
            if(!empty($_POST['Purchasing']['person2']))
                    $information[] = $department.'审批人'.$_POST['Purchasing']['person2'].' 意见：'.$_POST['Purchasing']['reason2'];
            if(!empty($_POST['Purchasing']['person3']))
                    $information[] = $department.'审批人'.$_POST['Purchasing']['person3'].' 意见：'.$_POST['Purchasing']['reason3'];
            return json_encode($information);
        }

        public function actionApprove($id){
            $model = $this->loadModel($id);
            if(isset($_POST['Purchasing'])){
                    $userInfo = User::getInfo();
		            if(($model->status == Purchasing::STATUS_APPLY && Yii::app() -> authManager -> checkAccess('college',Yii::app()->user->getId()))){
                        //TJ:学院审批
                        if($model->user->department_id != $userInfo->department_id) return false;
                        
                        if($_POST['Purchasing']['approve'] == '1'){
                            $model -> status = Purchasing::STATUS_PASS_FIRST;
                        }
                        else if($_POST['Purchasing']['approve'] == '-1'){
                            $model -> status = Purchasing::STATUS_REJECT;
                        }
                    
                        $model->information = $this::getInformation($model,$userInfo,'学院');
                        $model->save();
                    }
                    
                    if( ($model->status == Purchasing::STATUS_PASS_FIRST || $model->status == Purchasing::STATUS_PASS_SCHOOL) && Yii::app() -> authManager -> checkAccess('secure',Yii::app()->user->getId())){
                            //保卫处审批
                            $information = json_decode($model -> information,true);
                            if($_POST['Purchasing']['approve'] == '1'){
                                    $model -> status = $model->status == Purchasing::STATUS_PASS_SCHOOL ? Purchasing::STATUS_PASS_FINAL : Purchasing::STATUS_PASS_SECURE;
                            }
                            if($_POST['Purchasing']['approve'] == '-1'){
                                    $model -> status = Purchasing::STATUS_REJECT;
                            }
                            $model->information = $this::getInformation($model,$userInfo,'保卫处');
                            $model->save();
                    }
        
                    if( ($model->status == Purchasing::STATUS_PASS_FIRST || $model->status == Purchasing::STATUS_PASS_SECURE) && Yii::app() -> authManager -> checkAccess('school',Yii::app()->user->getId())){
                            if($_POST['Purchasing']['approve'] == '1'){
                                    $model -> status = $model->status == Purchasing::STATUS_PASS_SECURE ? Purchasing::STATUS_PASS_FINAL : Purchasing::STATUS_PASS_SCHOOL;
                            }
                            if($_POST['Purchasing']['approve'] == '-1'){
                                    $model -> status = Purchasing::STATUS_REJECT;
                            }
                            $model->information = $this::getInformation($model,$userInfo,'学校');
                            $model->save();
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

     //TJ:这里删掉了ActionCreate(),因为用不到了

    public function actionApply()		//TJ:创建新申购的控制器
	{
		$model=new Chemlist;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Chemlist']))
		{
			$model->attributes=$_POST['Chemlist'];		//TJ:注意这里表示chemlist类信息
            $model->production_date = date('Y-m-d');
            $userInfo = User::getInfo();							//通过框架功能获取用户信息
            $model->user_id = $userInfo -> user_id;		//填入用户ID
            $model->status = Purchasing::STATUS_APPLY;
            $image = CUploadedFile::getInstance($model, 'pics');
            if( is_object($image) && get_class($image) === 'CUploadedFile' ){  
                    $model->pics = uniqid().'.jpg';                     //随机改名
                    $image->saveAs(Yii::app()->basePath.'/../upload/'.$model->pics);  //保存到upload文件夹
            }else{  
                    $model->pics = 'NoPic.jpg';  
            } 
			if($model->save())
            {
                    $model2=new Purchasing;			//TJ:这里新建采购单类
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
	
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Purchasing');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	} */

	public function actionAdmin()
	{
		$this->layout='//layouts/purchasing_admin';			//这里重设layout来显示两个左边快捷列表
		//if(!isset($_GET['status'])) $_GET['status']='APPROVE';	//如果没设status，默认为查看“待审”
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
