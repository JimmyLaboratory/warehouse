<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
                $condition = new CDbCriteria();
                $condition ->compare('user_name', $this->username);
                $user = User::model() -> find($condition);
                if(empty($user)){
                        $this->errorCode=self::ERROR_USERNAME_INVALID;
                }
                elseif(!empty($this->username) && !empty($this->password) && $user->password == md5($this->password) && $user->lock != '1')
                {
                        $roleSeted = Yii::app() -> authManager -> getRoles();
                        if(!isset($roleSeted[$user->user_role])){
                                Yii::app() -> authManager ->createRole($user->user_role);
                        }
                        $roleAssigned = Yii::app() -> authManager -> getAuthAssignments($this->username);
                        foreach($roleAssigned as $key => $value){
                                Yii::app() -> authManager -> revoke($key, $this->username);
                        }
                        Yii::app() -> authManager -> assign($user->user_role,$this->username);
                        Yii::app() -> authManager -> save();
                        $this->errorCode = self::ERROR_NONE;
                }
                elseif($user->password != md5($this->password)){
                        $this->errorCode=self::ERROR_PASSWORD_INVALID;
                }
                elseif($user->lock == '1'){
                        $this->errorCode=3;
                }
                else{
                        $this->errorCode=self::ERROR_USERNAME_INVALID;
                }
                return !$this->errorCode;
	}
}