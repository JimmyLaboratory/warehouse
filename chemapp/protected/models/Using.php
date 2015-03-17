<?php

/**
 * This is the model class for table "using".
 *
 * The followings are the available columns in table 'using':
 * @property integer $using
 * @property integer $chem_id
 * @property integer $user_id
 * @property integer $timestamp
 * @property double $applyuse
 * @property string $reason
 * @property string $use_start
 * @property integer $useway
 * @property string $junk
 * @property integer $status
 * @property string $information
 */
class Using extends CActiveRecord
{
        const STATUS_APPLY = 1;//申请提交，未审批
        const STATUS_CANCEL = -1;//取消申请
        const STATUS_REJECT = 0;//审批被拒绝
        const STATUS_APPROVE_FIRST = 2;//初审完成（学院）
        const STATUS_APPROVE_FINAL = 3;//审批完成（学校）
        const STATUS_FINISHED = 4;//已领用
        
        public static function getStatusInfo($id){
                switch($id){
                        case self::STATUS_APPLY:return '申请提交，未审批';
                        case self::STATUS_CANCEL:return '取消申请';
                        case self::STATUS_REJECT:return '审批被拒绝';
                        case self::STATUS_APPROVE_FIRST:return '学院初审通过';
                        case self::STATUS_APPROVE_FINAL:return '审批已完成，请派人领取';
                        case self::STATUS_FINISHED:return '已领用';
                }
        }
        
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Using the static model class
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
		return 'using';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('using_id, chem_id, user_id, timestamp, applyuse, reason, use_start, useway, junk, status', 'required'),
			array('chem_id, user_id, timestamp, useway, status', 'numerical', 'integerOnly'=>true),
			array('applyuse', 'numerical'),
                        array('information', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('using_id, chem_id, user_id, timestamp, applyuse, reason, use_start, useway, junk, status, information', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
                    'chemlist'=>array(self::BELONGS_TO, 'Chemlist', 'chem_id'),
                    'user'=>array(self::BELONGS_TO, 'User', 'user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'using_id' => '申请使用单编号',
			'chem_id' => '化学品',
			'user_id' => '申请人',
			'timestamp' => '申请时间',
			'applyuse' => '申请使用量',
			'reason' => '申请原因',
			'use_start' => '预计开始使用日期',
			'useway' => '使用方向',
			'junk' => '废弃物处理方式',
			'status' => '审批状态',
			'information' => '审批信息',
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
                                if(!empty($this->user_id)){
                                        $teachers = Yii::app()->db->createCommand('select user_id from user where realname LIKE "%'.$this->user_id.'%"')->queryColumn();
                                        $criteria ->addInCondition('user_id', $teachers);
                                }
                                else{
                                        $teachers = Yii::app()->db->createCommand('select user_id from user where department_id='.$userInfo->department_id)->queryColumn();
                                        $criteria ->addInCondition('user_id', $teachers);
                                }
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
                                case 'APPROVE':
                                        if($userInfo->user_role == 'college'){
                                                $criteria ->addInCondition('status', array(Using::STATUS_APPLY));
                                        }
                                        if($userInfo->user_role == 'school'){
                                                $criteria ->addInCondition('status', array(Using::STATUS_APPROVE_FIRST));
                                        }
                                        else{
                                                $criteria ->addInCondition('status', array(Using::STATUS_APPLY,Using::STATUS_APPROVE_FIRST));
                                        }
                                        break;
                                case 'BEPICK':
                                        $criteria ->addInCondition('status', array(Using::STATUS_APPROVE_FINAL));
                                        break;
                        }
                }
		$criteria->compare('using_id',$this->using_id);
		$criteria->compare('chem_id',$this->chem_id);
		$criteria->compare('timestamp',$this->timestamp);
		$criteria->compare('applyuse',$this->applyuse);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('use_start',$this->use_start,true);
		$criteria->compare('useway',$this->useway);
		$criteria->compare('junk',$this->junk,true);
		$criteria->compare('information',$this->information,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}