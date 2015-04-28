<?php

/**
 * This is the model class for table "achieve".
 *
 * The followings are the available columns in table 'achieve':
 * @property string $achieve_id
 * @property integer $timestamp
 * @property integer $status 				//备案状态
 * @property string $achiever
 * @property string $achieve_info
 * @property string $note
 * @property integer $purchasing_id 		//采购申请编号
 */
class Achieve extends CActiveRecord
{
	const STATUS_SENDING = 0 ; //备案中
	const STATUS_SUCCESS = 1 ;//备案成功
	const STATUS_FAILED = -1 ;//备案失败
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Achieve the static model class
	 */
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
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'achieve';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array(' timestamp, achiever, note,purchasing_id', 'required'),
			array('timestamp', 'numerical', 'integerOnly'=>true),
			array('achieve_id,status', 'length', 'max'=>30),
			array('achiever', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('achieve_id, timestamp, achiever, note', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'purchasing_id'=>'采购申请编号',
			'achieve_id' => '备案单编号',
			'timestamp' => '备案时间',
			'achiever' => '备案人',
			'achieve_info' => '采购单信息',
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
		$criteria->compare('timestamp',$this->timestamp);
		$criteria->compare('achiever',$this->achiever,true);
		$criteria->compare('achieve_info',$this->achieve_info,true);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchByStatus($id)		//通过备案状态来查找记录
	{
		$criteria=new CDbCriteria;
		$criteria->compare('status',$id,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}