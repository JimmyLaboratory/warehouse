<?php

/**
 * This is the model class for table "chemlist".
 *
 * The followings are the available columns in table 'chemlist':
 * @property integer $chem_id
 * @property integer $status
 * @property integer $user_id
 * @property integer $chemcat_id
 * @property string  $chem_name
 * @property integer $quality_id
 * @property string $quality_other
 * @property double $unit_package
 * @property integer $unit_id
 * @property integer $nums
 * @property string $production_date
 * @property integer $expired
 * @property string $producer
 * @property integer $useway
 * @property integer $supplier_id
 * @property string $supplier_code
 * @property string $supplier_other
 * @property string $specail_note
 * @property string $note
 * @property double $used
 * @property string $purpose			//使用目的
 * @property string $url 				//药品介绍网址	
 * @property string $pics 				//药品样品图片
 * @property integer $storage_id
 */
class Chemlist extends CActiveRecord
{
        const STATUS_APPLY = 1;//审批中
        const STATUS_REJECT = 0;//审批拒绝
        const STATUS_APPROVE = 2;//审批完成
        const STATUS_INSTOCK = 3;//化学品在库
        const STATUS_USEOVER = 4;//使用毕了
        const STATUS_LOCK = -1;//化学品在库冻结中，禁止使用
        const STATUS_CANCEL = -2;//采购被终止

        public static function getStatusInfo($id){
                switch($id){
                        case self::STATUS_APPLY:return '审批流程进行中';
                        case self::STATUS_APPROVE:return '审批完成';
                        case self::STATUS_REJECT:return '审批拒绝';
                        case self::STATUS_INSTOCK:return '化学品在库';
                        case self::STATUS_USEOVER:return '使用毕了';
                        case self::STATUS_LOCK:return '冻结';
                        case self::STATUS_CANCEL:return '采购终止';
                }
        }
                
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Chemlist the static model class
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
		return 'chemlist';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('status, user_id, chemcat_id, quality_id, unit_package, unit_id, nums, production_date, expired, useway, chem_name', 'required'),
			array('status, user_id, chemcat_id, quality_id, unit_id, nums, useway, supplier_id, storage_id', 'numerical', 'integerOnly'=>true),
			array('unit_package, supplier_id,used',  'numerical'),
            array('expired', 'length', 'max'=>10),
			array('quality_other', 'length', 'max'=>60),
			array('producer, supplier_other', 'length', 'max'=>50),
			array('supplier_code', 'length', 'max'=>30),
            array('specail_note', 'length', 'max'=>1000),
            array('foundation', 'length', 'max'=>1000),
            array('note', 'length', 'max'=>1000),
            array('purpose', 'length', 'max'=>1000),
            array('url', 'length', 'max'=>1000),
            array('pics', 'length', 'max'=>1000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('chem_id, status, user_id, chemcat_id, chem_name, quality_id, quality_other, unit_package, unit_id, nums, production_date, expired, producer, useway, supplier_id, supplier_code, supplier_other, specail_note, note, used, storage_id', 'safe', 'on'=>'search'),
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
	        'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
	        'quality'=>array(self::BELONGS_TO, 'Quality', 'quality_id'),
	        'unit'=>array(self::BELONGS_TO, 'Unit', 'unit_id'),
	        'supplier'=>array(self::BELONGS_TO, 'Supplier', 'supplier_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'chem_id' => '化学品ID',
			'chem_name'=>'药品名称',
			'status' => '状态',
			'user_id' => '归属用户',
			'chemcat_id' => '所属分类',
			'quality_id' => '规格',
			'quality_other' => '规格补充',
			'unit_package' => '包装',
			'unit_id' => '单位',
			'nums' => '数量',
			'production_date' => '生产日期',
			'expired' => '有效期',
			'producer' => '生产厂商',
			'useway' => '使用方向',
			'purpose'=> '使用目的',
			'supplier_id' => '供应商',
			'supplier_code' => '供应商内部货号',
			'supplier_other' => '其它供应商',
			'specail_note' => '特殊说明',
			'note' => '备注',
			'used' => '已使用',
			'storage_id' => '存储仓库',
            'foundation' => '数据测量依据',
            'url' => '药品简介网址',
            'pics' => '图片'
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
                                        
                                        throw new CHttpException(504,'搜索功能还不完善，敬请期待');
                                }
                                else{
                                        $teachers = Yii::app()->db->createCommand("select user_id from user where department_id=".$userInfo->user_id)->queryColumn();
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
                if(!empty($this->storage_id)){
                        $storages = Yii::app()->db->createCommand('select storage_id from `storage` where storage_name LIKE "%'.$this->storage_id.'%"')->queryColumn();
                        $criteria ->addInCondition('storage_id', $storages);
                }

		$criteria->compare('chem_id',$this->chem_id);
        $criteria->compare('chem_name',$this->chem_name,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('chemcat_id',$this->chemcat_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getUsewayOptions($id = null){
                $options = array('0'=>'请选择','1'=>'教学','2'=>'科研');
                if($id) return $options[$id];
                else return $options;
        }
        public static function getChemName($id){
        	$model=self::findByPk($id);
        	return $model->chem_name;
        }
}