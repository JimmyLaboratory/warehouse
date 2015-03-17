<?php

/**
 * This is the model class for table "instorage".
 *
 * The followings are the available columns in table 'instorage':
 * @property integer $instorage_id
 * @property string $purchasing_id
 * @property integer $user_id
 * @property string $verifydate
 * @property string $expired
 * @property string $specail_note
 * @property string $weight
 * @property integer $nums
 * @property integer $storage_id
 * @property string $deliver_name
 * @property string $deliver_tel
 * @property string $note
 * @property string $pics
 */
class Instorage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Instorage the static model class
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
		return 'instorage';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('purchasing_id, user_id, verifydate, expired, weight, nums, storage_id, pics', 'required'),
			array('nums, storage_id', 'numerical', 'integerOnly'=>true),
			array('weight', 'length', 'max'=>50),
			array('purchasing_id', 'length', 'max'=>20),
                        array('deliver_name', 'length', 'max'=>40),
                        array('deliver_tel', 'length', 'max'=>20),
                        array('specail_note', 'length', 'max'=>500),
                        array('user_id', 'length', 'max'=>100),
                        array('note', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('instorage_id, purchasing_id, user_id, verifydate, expired, specail_note, weight, nums, storage_id, note, pics', 'safe', 'on'=>'search'),
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
                    'hander' => array(self::BELONGS_TO, 'User', 'user_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'instorage_id' => '入库编号',
			'purchasing_id' => '采购单编号',
			'user_id' => '验收人',
			'verifydate' => '验收日期',
			'expired' => '化学品质保期限',
			'specail_note' => '存放注意事项',
			'weight' => '实际称重',
			'nums' => '验收数量',
			'storage_id' => '存放仓库（货架）',
			'note' => '备注',
			'pics' => '图片',
                        'deliver_name' => '送货人',
			'deliver_tel' => '送货人电话',
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

		$criteria->compare('instorage_id',$this->instorage_id);
		$criteria->compare('purchasing_id',$this->purchasing_id,true);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('verifydate',$this->verifydate,true);
		$criteria->compare('expired',$this->expired,true);
		$criteria->compare('specail_note',$this->specail_note,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('nums',$this->nums);
		$criteria->compare('storage_id',$this->storage_id);
		$criteria->compare('note',$this->note,true);
		$criteria->compare('pics',$this->pics,true);
                $criteria->compare('deliver_name',$this->deliver_name,true);
		$criteria->compare('deliver_tel',$this->deliver_tel,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}