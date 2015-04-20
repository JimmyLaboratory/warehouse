<?php

/**
 * This is the model class for table "chemcat".
 *
 * The followings are the available columns in table 'chemcat':
 * @property integer $cat_id
 * @property string $chemcat_name
 * @property integer $parent_id
 */
class Chemcat extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Chemcat the static model class
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
		return 'chemcat';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('chemcat_name, parent_id', 'required'),
			array('parent_id', 'numerical', 'integerOnly'=>true),
			array('chemcat_name', 'length', 'max'=>60),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('cat_id, chemcat_name, parent_id', 'safe', 'on'=>'search'),
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
			'cat_id' => '分类ID',
			'chemcat_name' => '分类名称',
			'parent_id' => '父级分类',
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

		$criteria->compare('cat_id',$this->cat_id);
		$criteria->compare('chemcat_name',$this->chemcat_name,true);
		$criteria->compare('parent_id',$this->parent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function searchByParentID($parent_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;


		$criteria->compare('parent_id',$parent_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public static function getLevels($id,$lastQuery = ''){
                if(empty($id)) return $lastQuery;
                $result = Yii::app() -> db ->createCommand('SELECT * FROM chemcat WHERE cat_id=:id')
                                           ->bindParam(':id', $id)
                                           ->queryRow();
                $lastQuery = $result['chemcat_name'].' '.$lastQuery;
                return self::getLevels($result['parent_id'],$lastQuery);
        }
        
        public static function getDropListById($id){
                $result = Yii::app() -> db ->createCommand('SELECT * FROM chemcat WHERE cat_id=:id')
                                           ->bindParam(':id', $id)
                                           ->queryRow();
                $output = array();
                $output[$result['cat_id']] = $result['chemcat_name'];
                return $output;
        }
        
        public static function getDropList($cur_parent_id){
                if(empty($cur_parent_id)){
                        return array('0'=>'顶级分类');
                }
                else{
                        $parent_id = Yii::app() -> db ->createCommand('SELECT parent_id FROM chemcat WHERE cat_id=:cur_parent_id')
                                           ->bindParam(':cur_parent_id', $cur_parent_id)
                                           ->queryScalar();
                        $return = array();
                        $result = Yii::app() -> db ->createCommand('SELECT * FROM chemcat WHERE parent_id=:parent_id')
                                                   ->bindParam(':parent_id', $parent_id)
                                                   ->queryAll();
                        foreach($result as $storage){
                                $return[$storage['cat_id']] = $storage['chemcat_name'];
                        }
                        return $return;
                }                
        }

        
}