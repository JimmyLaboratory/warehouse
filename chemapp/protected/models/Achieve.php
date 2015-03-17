<?php

/**
 * This is the model class for table "achieve".
 *
 * The followings are the available columns in table 'achieve':
 * @property string $achieve_id
 * @property integer $timestamp
 * @property string $achiever
 * @property string $achieve_info
 * @property string $note
 */
class Achieve extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Achieve the static model class
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
			array('achieve_id, timestamp, achiever, achieve_info, note', 'required'),
			array('timestamp', 'numerical', 'integerOnly'=>true),
			array('achieve_id', 'length', 'max'=>30),
			array('achiever', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('achieve_id, timestamp, achiever, achieve_info, note', 'safe', 'on'=>'search'),
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
			'achieve_id' => '备案单编号',
			'timestamp' => '备案时间',
			'achiever' => '备案人',
			'achieve_info' => '采购单信息',
			'note' => '备注',
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
}