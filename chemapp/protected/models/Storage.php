<?php

/**
 * This is the model class for table "storage".
 *
 * The followings are the available columns in table 'storage':
 * @property integer $storage_id
 * @property string $storage_name
 * @property string $note
 * @property integer $parent_id
 */
class Storage extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Storage the static model class
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
		return 'storage';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('storage_name, parent_id', 'required'),
			array('parent_id', 'numerical', 'integerOnly'=>true),
			array('storage_name', 'length', 'max'=>60),
			array('note', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('storage_id, storage_name, note, parent_id', 'safe', 'on'=>'search'),
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
			'storage_id' => 'Storage',
			'storage_name' => '仓库（位置）名称',
			'note' => '备注',
			'parent_id' => '上级存储位置',
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

		$criteria->compare('storage_id',$this->storage_id);
		$criteria->compare('storage_name',$this->storage_name,true);
		$criteria->compare('note',$this->note,true);
                if(isset($this->parent_id) && $this->parent_id > 0){
                        
                }
                elseif(!empty($_GET['parent_id']) && (int)$_GET['parent_id'] > 0){
                        $this->parent_id = $_GET['parent_id'];
                }
                else{
                        $this->parent_id = 0;
                }
		$criteria->compare('parent_id',$this->parent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getLevels($id,$lastQuery = ''){
                if(empty($id)) return $lastQuery;
                $result = Yii::app() -> db ->createCommand('SELECT * FROM storage WHERE storage_id=:id')
                                           ->bindParam(':id', $id)
                                           ->queryRow();
                $lastQuery = $result['storage_name'].' '.$lastQuery;
                return self::getLevels($result['parent_id'],$lastQuery);
        }
        
        public static function getDropListById($id){
                $result = Yii::app() -> db ->createCommand('SELECT * FROM storage WHERE storage_id=:id')
                                           ->bindParam(':id', $id)
                                           ->queryRow();
                $output = array();
                $output[$result['storage_id']] = $result['storage_name'];
                return $output;
        }
        
        public static function getDropList($cur_parent_id){
                if(empty($cur_parent_id)){
                        return array('0'=>'顶级仓库');
                }
                else{
                        $parent_id = Yii::app() -> db ->createCommand('SELECT parent_id FROM storage WHERE storage_id=:cur_parent_id')
                                           ->bindParam(':cur_parent_id', $cur_parent_id)
                                           ->queryScalar();
                        $return = array();
                        $result = Yii::app() -> db ->createCommand('SELECT * FROM storage WHERE parent_id=:parent_id')
                                                   ->bindParam(':parent_id', $parent_id)
                                                   ->queryAll();
                        foreach($result as $storage){
                                $return[$storage['storage_id']] = $storage['storage_name'];
                        }
                        return $return;
                }                
        }
}