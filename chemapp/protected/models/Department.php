<?php

/**
 * This is the model class for table "department".
 *
 * The followings are the available columns in table 'department':
 * @property integer $department_id
 * @property string $department_name
 */
class Department extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Department the static model class
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
		return 'department';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('department_name', 'required'),
			array('department_name', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('department_id, department_name', 'safe', 'on'=>'search'),
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
			'department_id' => '部门ID',
			'department_name' => '部门名称',
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

		$criteria->compare('department_id',$this->department_id);
		$criteria->compare('department_name',$this->department_name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getOptions()
        {
                $output = array();
                $result = self::model() -> findAll();
                foreach ($result as $department)
                {
                        $output[$department['department_id']] = $department['department_name'];
                }
                return $output;
        }
        
        public static function getUserOption(){
                $user_name = Yii::app() -> user -> getId();
                $result = User::model() -> find('user_name=:user_name',array(':user_name'=>$user_name));
                $output = array();
                $output[$result->department_id] = $result->department->department_name;
                return $output;
        }
}