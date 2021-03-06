<?php

/**	
 * This is the model class for table "achieve".
 *
 * The followings are the available columns in table 'achieve':
 * @property string $achieve_id				备案成功获得的备案编号
 * @property integer $timestamp			TJ:
 * @property integer $status 				备案状态
 * @property string $achiever				备案人（经办人）
 * @property string $achieve_info			备案单信息（旧），将被TJ替换掉
 * @property string $purpose				购买用途
 * @property string $contractID			购销合同号
 * @property string $note						备注
 * @property string $certificate				证书号
 * @property string $document				公文号
 * @property string $exp_date				有效期
 * @property string $license_issuing_authority	发证机关
 * @property integer $purchasing_id 	采购申请编号
 */

class Achieve extends CActiveRecord
{
	const STATUS_SENDING = 0 ;	//TJ备案中
	const STATUS_SUCCESS = 1 ;	//备案成功
	const STATUS_FAILED = -1 ;		//备案失败

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public static function getStatusInfo($id){
        switch($id){
            case self::STATUS_SENDING:return '备案中';
            case self::STATUS_SUCCESS:return '备案成功';
            case self::STATUS_FAILED:return '备案失败';
        }
    }

	public function tableName()
	{
		return 'achieve';
	}

	public function rules()		//TJ:提交表单时检查规则
	{
		// 备案单
		return array(
			array('timestamp, achiever,purpose,purchasing_id,certificate,document,exp_date,license_issuing_authority', 'required'),		//必填项
			array('timestamp', 'numerical', 'integerOnly'=>true),
			array('achieve_id,status', 'length', 'max'=>30),
			array('achiever', 'length', 'max'=>100), //TJ备案人
			array('contractID','length','max'=>100),//购销合同号
			array('purpose', 'length', 'max'=>200), //采购用途
			array('note','length','max'=>500),			//备注
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('achieve_id, achiever', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// TJ：多表查询关系
		// 备案单需要采购信息，采购信息包含化学品信息
		return array(
			'purchasing'=>array(self::BELONGS_TO, 'Purchasing', 'purchasing_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()//TJ:字段名
	{
		return array(
			'purchasing_id'=>'采购申请编号',
			'achieve_id' => '备案单编号',
			'timestamp' => '备案时间',
			'achiever' => '备案人(经办人)',
			'purpose'=>'购买用途',
			'achieve_info' => '采购单信息',
			'contractID'=>'购销合同号',
			'certificate'=>'证书号',
			'document'=>'公文号',
			'exp_date'=>'有效期',
			'license_issuing_authority'=>'发证机关',
			'note' => '备注',
			'status'=>'状态',
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

		$criteria->compare('achieve_id',$this->achieve_id,true);
		$criteria->compare('achiever',$this->achiever,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchByStatus($id)		//TJ:通过备案状态来查找记录
	{
		$criteria=new CDbCriteria;
		$criteria->compare('status',$id);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}