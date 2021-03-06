<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $user_id
 * @property string $user_name
 * @property string $password
 * @property string $repassword
 * @property string $realname
 * @property string $user_role
 * @property integer $department_id
 * @property string $cardno
 * @property string $tel_long
 * @property integer $tel_short
 * @property string $tel_office
 * @property string $email
 * @property string $note
 * @property integer $lock
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'user';
	}
        
        public function beforeSave()
        {
                if(strlen($this->password) != 32){
                        $this->password = md5($this->password);
                }
				
				 if(strlen($this->repassword) != 32){
                        $this->repassword = md5($this->repassword);
                }
                if(Yii::app() -> authManager -> checkAccess('college',Yii::app()->user->getId())){
                        if($this->user_role != 'teacher') return false;
                        //$userData = User::model() -> find('user_name=:user_name',array(':user_name'=>Yii::app()->user->getId()));
                        //if($this->department_id != $userData -> department_id) return false;
                }
                return parent::beforeSave();
        }
        
        public function afterSave() {
                $roleSeted = Yii::app() -> authManager -> getRoles();
                if(!isset($roleSeted[$this->user_role])){
                        Yii::app() -> authManager ->createRole($this->user_role);
                }
                $roleAssigned = Yii::app() -> authManager -> getAuthAssignments($this->user_name);
                foreach($roleAssigned as $key => $value){
                        Yii::app() -> authManager -> revoke($key, $this->user_name);
                }
                if($this->lock == '1'){
                        Yii::app() -> authManager -> save();
                        //lock, remove all privillges
                }else{
                        Yii::app() -> authManager -> assign($this->user_role,$this->user_name);
                        Yii::app() -> authManager -> save();
                }
                parent::afterSave();
        }

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_name, password ,realname, user_role, cardno, tel_long, tel_short, tel_office, email, note, lock,dname', 'required'),
			array(' tel_short, lock', 'numerical', 'integerOnly'=>true),
			array('user_name, email', 'length', 'max'=>60),
			array('password','length', 'max'=>32),
			array('realname, tel_office', 'length', 'max'=>20),
			array('user_role', 'length', 'max'=>10),
			array('cardno', 'length', 'max'=>30),
			array('tel_long', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('user_id, user_name, password, realname, user_role, department_id, cardno, tel_long, tel_short, tel_office, email, note, lock', 'safe', 'on'=>'search'),
			//array('repassword', 'compare', 'compareAttribute'=>'password'),
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
                    //'department' => array(self::BELONGS_TO, 'Department', 'department_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'user_id' => '用户ID',
			'user_name' => '用户名',
			'password' => '密码',
			'repassword' => '确认密码',
			'realname' => '姓名',
			'user_role' => '用户角色',
			'dname' => '学院/部门',
			'cardno' => '卡号',
			'tel_long' => '长号',
			'tel_short' => '短号',
			'tel_office' => '办公电话',
			'email' => '邮箱',
			'note' => '备注',
			'lock' => '帐户状态',
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
        /*if($userInfo -> user_role == 'college'){
            $this->department_id = $userInfo->department_id;
        }*/
		$criteria->compare('department_id',$userInfo->user_id);

		//$criteria->compare('user_name',$this->user_name,true);
		$criteria->compare('realname',$this->realname,true);
		$criteria->compare('user_role',$this->user_role,true);
		//$criteria->compare('department_id',Yii::app()->user->getID(),true);
		$criteria->compare('lock',$this->lock);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public static function getRoleOptions()
    {
            return array(
                'school' => '学校',
                'secure' => '保卫处',
                'college' => '学院',
                //'teacher' => '教师',教师由学院创建。
            );
    }

	public function getRoleName()
    {
		switch ($this->user_role) {
			case 'school': $ret = '学校'; break;
			case 'secure': $ret = '保卫处'; break;
			case 'college': $ret = '学院'; break;
			//case 'teacher': $ret = '教师'; break;
			default: $ret = '未知'; break;
		} return $ret;
    }
    
    public static function getInfo(){
            if(Yii::app()->user->isGuest) return false;
			//if($name)
			//	return User::model() ->find('user_name=:user_name',array(':user_name'=>$name));
			//else
				return User::model() ->find('user_name=:user_name',array(':user_name'=>Yii::app()->user->getId()));
    }
    public static function showLock($int){
    	if($int == 1){
    		return '冻结' ;
    	}
    	else return '有效';
    }
}