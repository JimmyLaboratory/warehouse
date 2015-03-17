<?php

/**
 * This is the model class for table "outstorage".
 *
 * The followings are the available columns in table 'outstorage':
 * @property integer $outstorage_id
 * @property integer $using_id
 * @property integer $apply_user_id
 * @property integer $duty_user_id
 * @property string $datetime
 * @property string $note
 */
class Outstorage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ou the static model class
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
		return 'outstorage';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('using_id, apply_user_id, duty_user_id, datetime', 'required'),
			array('duty_user_id', 'numerical', 'integerOnly'=>true),
                        array('note','length','max'=>'500'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('outstorage_id, using_id, apply_user_id, duty_user_id, datetime, note', 'safe', 'on'=>'search'),
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
			'outstorage_id' => '出库编号',
			'using_id' => '使用申请单编号',
			'apply_user_id' => '领用人真实姓名',
			'duty_user_id' => '出库负责人',
			'datetime' => '领用时间',
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

		$criteria->compare('outstorage_id',$this->outstorage_id);
		$criteria->compare('using_id',$this->using_id);
		$criteria->compare('apply_user_id',$this->apply_user_id);
		$criteria->compare('duty_user_id',$this->duty_user_id);
		$criteria->compare('datetime',$this->datetime,true);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}