<?php

/**
 * This is the model class for table "supplier".
 *
 * The followings are the available columns in table 'supplier':
 * @property integer $supplier_id
 * @property string $supplier_name
 * @property string $website
 * @property string $email
 * @property string $contact
 * @property string $tel
 * @property string $representative
 * @property string $com_tel
 * @property string $note
 */
class Supplier extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Supplier the static model class
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
		return 'supplier';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('supplier_name, contact, tel', 'required'),
			array('supplier_name', 'length', 'max'=>60),
			array('website', 'length', 'max'=>200),
			array('email', 'length', 'max'=>100),
			array('contact, representative', 'length', 'max'=>30),
			array('tel, com_tel', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('supplier_id, supplier_name, website, email, contact, tel, representative, com_tel, note', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			//'supplier_id' => '所属学院号',
			'user_id' =>'所属学院',
			'supplier_name' => '供应商名称',
			'website' => '网站',
			'email' => '邮箱',
			'contact' => '供应商联系人',
			'tel' => '联系人电话',
			'representative' => '法定代表人',
			'com_tel' => '单位电话',
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

		//$criteria->compare('supplier_id',$this->supplier_id);
		//TJ：这个是分学院管理供应商的admin页面检索办法，通过搜索所属部门ID和本用户登陆ID相同的供应商找到本学院的供应商
		$criteria->compare('user_id',User::getInfo()->user_id);

		$criteria->compare('supplier_name',$this->supplier_name,true);
		$criteria->compare('website',$this->website,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('contact',$this->contact,true);
		$criteria->compare('tel',$this->tel,true);
		$criteria->compare('representative',$this->representative,true);
		$criteria->compare('com_tel',$this->com_tel,true);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}