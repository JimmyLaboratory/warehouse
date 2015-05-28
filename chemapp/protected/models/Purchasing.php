<?php

/**
 * This is the model class for table "purchasing".
 *
 * The followings are the available columns in table 'purchasing':
 * @property string $purchasing_id
 * @property integer $chem_id
 * @property integer $user_id
 * @property integer $timestamp
 * @property integer $status
 * @property string $information
 */
class Purchasing extends CActiveRecord
{
        const STATUS_CANCEL = -2;//采购特殊情况被拒绝, 采购终止
        const STATUS_EDIT = -1;//申请撤消，重新编辑后可以再次递交审批
        const STATUS_APPLY = 1;//提交申请，未进行任何审批
        const STATUS_REJECT = 0;//审批被拒绝
        const STATUS_PASS_FIRST = 2;//学院初审通过								100
        const STATUS_PASS_SECURE = 3;//保卫处审核通过							
        const STATUS_PASS_SCHOOL = 4;//学校审核通过
        const STATUS_PASS_FINAL = 5;//学院和学校和保卫处均审核通过
        const STATUS_ARCHIVES = 6;//备案中
        const STATUS_ARCHIVES_SUCCESS = 7;//备案成功
        const STATUS_ARCHIVES_FAILED = -3;//备案失败
        const STATUS_PURCHASING = 10;//采购中
        const STATUS_INSTOCK = 11;//化学品采购完毕在库
        const STATUS_LOCK = -99;//采购申请单被冻结，不能进行任何操作			

        public static function getStatusInfo($id){
                switch($id){
                        case self::STATUS_CANCEL:return '特殊情况被终止';
                        case self::STATUS_EDIT:return '申请撤消';
                        case self::STATUS_APPLY:return '提交申请，尚未审批';
                        case self::STATUS_REJECT:return '审批被拒绝';
                        case self::STATUS_PASS_FIRST:return '学院初审通过';
                        case self::STATUS_PASS_SECURE:return '保卫处审核通过';
                        case self::STATUS_PASS_SCHOOL:return '学校审核通过';
                        case self::STATUS_PASS_FINAL:return '已完成审批';
						case self::STATUS_ARCHIVES_SUCCESS:return '已完成备案';
                        case self::STATUS_PURCHASING:return '采购中';
                        case self::STATUS_INSTOCK:return '采购完毕在库';
                        case self::STATUS_LOCK:return '冻结，不能进行任何操作';
                }
        }
        
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Purchasing the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'purchasing';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchasing_id, chem_id, user_id, timestamp, status, information', 'required'),
			array('chem_id, user_id, timestamp, status', 'numerical', 'integerOnly'=>true),
			array('purchasing_id', 'length', 'max'=>20),
                        array('purchasing_no', 'length', 'max'=>32),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('purchasing_id, chem_id, user_id, timestamp, status, information', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()//TJ多表查询的关系设置
	{
		// 师兄这个混蛋，这么重要的地方竟然不写注释
		// 害我找了半天
		//有了这个就能方便的在一个类对象中存放多个表的字段信息
		//例如$model->chemlist->chem_name,$model是purchasing类对象,chemlist是表，chem_name是chemlist表中的字段
		return array(
			'chemlist'=>array(self::BELONGS_TO, 'Chemlist', 'chem_id'),
			'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'purchasing_id' => '采购申请编号',
			'chem_id' => '化学品编号',
			'user_id' => '申请人',
			'timestamp' => '提交申请时间',
			'status' => '状态',
			'information' => '信息',
            'purchasing_no' => '采购清单编号'
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                $userInfo = User::getInfo();
                switch ($userInfo->user_role){
                        case 'teacher':
                                $this->user_id = $userInfo->user_id;
                                $criteria->compare('user_id',$this->user_id);
                                break;
                        case 'college':
                                /*TJ:师兄写的检索申请条件，估计是看本学院下的申请，我给purchasing加个学院属性吧，轻松解决这个问题
								if(!empty($this->user_id)){
                                        $teachers = Yii::app()->db->createCommand('select user_id from user where realname LIKE "%'.$this->user_id.'%"')->queryColumn();
                                        $criteria ->addInCondition('user_id', $teachers);
                                }
                                else{
                                        $teachers = Yii::app()->db->createCommand('select user_id from user where department_id='.$userInfo->department_id)->queryColumn();
                                        $criteria ->addInCondition('user_id', $teachers);
                                }*/
								$criteria ->compare('d_id', $userInfo->user_id);
								//TJ：一行代码解决，我都不想说什么了，师兄应该感到欣慰，我没有辜负老师的期望
								//d_id是department_id的意思
                                break;
                        case 'secure':
                        case 'school':
                                if(!empty($this->user_id)){
                                        $teachers = Yii::app()->db->createCommand('select user_id from user where realname LIKE "%'.$this->user_id.'%"')->queryColumn();
                                        $criteria ->addInCondition('user_id', $teachers);
                                }
                                break;
                }
                
                if(isset($_GET['status'])){
                        switch ($_GET['status']){
								case 'MOVING':
									//TJ:这个只有老师用，暂时不加角色检查，查看的的是所有未被拒绝的进行着的申购
								$criteria ->addNotInCondition('status', array(Purchasing::STATUS_REJECT,Purchasing::STATUS_CANCEL));
								break;
                                case 'APPROVE':
                                        if($userInfo->user_role == 'college'){
                                                $criteria ->addInCondition('status', array(Purchasing::STATUS_APPLY));
                                        }
                                        if($userInfo->user_role == 'secure'){
                                                $criteria ->addInCondition('status', array(Purchasing::STATUS_PASS_FIRST,  Purchasing::STATUS_PASS_SCHOOL));
                                        }
                                        if($userInfo->user_role == 'school'){
                                                $criteria ->addInCondition('status', array(Purchasing::STATUS_PASS_FIRST,  Purchasing::STATUS_PASS_SECURE));
                                        }
                                        if($userInfo->user_role == 'teacher'){
                                                $criteria ->addInCondition('status', array(Purchasing::STATUS_APPLY, Purchasing::STATUS_PASS_FIRST,  Purchasing::STATUS_PASS_SECURE));
                                        }
                                        break;
								case 'PASS':
										if($userInfo->user_role == 'college'){
                                                $criteria ->addInCondition('status', array(Purchasing::STATUS_PASS_FIRST));
                                        }
                                        if($userInfo->user_role == 'secure'){
                                                $criteria ->addInCondition('status', array(Purchasing::STATUS_PASS_SECURE,  Purchasing::STATUS_PASS_SCHOOL));
                                        }
                                        if($userInfo->user_role == 'school'){
                                                $criteria ->addInCondition('status', array(Purchasing::STATUS_PASS_SCHOOL,  Purchasing::STATUS_PASS_SECURE));
                                        }
                                        if($userInfo->user_role == 'teacher'){
                                                $criteria ->addInCondition('status', array(Purchasing::STATUS_APPLY, Purchasing::STATUS_PASS_FIRST,  Purchasing::STATUS_PASS_SECURE));
                                        }
                                        break;
								case 'PURCHASING':
                                        $criteria ->addInCondition('status', array(Purchasing::STATUS_ARCHIVES_SUCCESS));
                                        break;
                        }
                }
                else{
                        $criteria->compare('status', $this->status);
                }
                
		$criteria->compare('purchasing_id',$this->purchasing_id,true);
		//$criteria->compare('chem_id',$this->chem_id);
		//$criteria->compare('timestamp',$this->timestamp);
		//$criteria->compare('information',$this->information,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	public static function check($status){//检查是否有审批申请的函数
	
	$result = Yii::app()->db->createCommand()
			->select('status')
			->from('purchasing')
			->where('status=:s',array(':s'=>$status))
			->queryRow();
			
	if($result)
		$need=true;
	else
		$need=false;
	
	return $need;
	}
	
}