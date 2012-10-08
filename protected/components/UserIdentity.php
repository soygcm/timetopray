<?php
/**
 * class UserIdentity
 * @author Igor Ivanović
 * Main extended core yii framework class used for auth system 
 */
class UserIdentity extends CUserIdentity
{

    /**
     * 
     * @var type int
     */
    public $_id;

    /**
     * Overrided parent method
     * @return type 
     */
    public function getId() 
    {
        return $this->_id;
    }

    /**
     * Authenticate user
     * @return type 
     */
    public function authenticate() 
    {
        //$record=User::model()->findByAttributes(array('usuario'=>$this->username));
        $user = User::prepareUserForAuthorisation($this->username);
        
	if($user === NULL) 
        {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        } 
        else if( !$user->ValidatePassword($this->password) ) 
        {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        } 
        else 
        {         
            $this->_id       = $user->facebook_id;
            $this->username  = $user->nombre;
            $this->setState('apellido', $user->apellido);
            $this->setState('correo', $user->correo);
            $this->setState('url', $user->facebook_url);
            $this->errorCode = self::ERROR_NONE;
	}
        
	return $this->errorCode;
    }
    
}
