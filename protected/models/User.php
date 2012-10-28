<?php
/**
 * class User
 * @author Igor Ivanović
 * 
 */
class User extends CActiveRecord
{
    /**
     * Table name
     * @return string 
     */
    public function tableName() 
    {
        return 'usuario';
    }
    
    public function relations()
    {
        return array(
            'usuario_datos'=>array(self::HAS_MANY, 'Dato', 'usuario_id'),
        );
    }

     /**
     * Return current object in static 
     * @param type $className this
     * @return type object
     */
    public static function model($className = __CLASS__) 
    {
        return parent::model($className);
    }
    
    /**
     * Selects user in database and return data
     * @param type $username
     * @return \user|null 
     */
    public static function prepareUserForAuthorisation( $username )
    {

        if( strpos($username, "@") )
        {
            $user = self::model()->find( 'LOWER(correo)=?', array($username) );
        }
        else 
        {
            // $user = self::model()->notDeleted()->find( 'LOWER(username)=?', array($username) );
            $user = self::model()->find( 'LOWER(usuario)=?', array($username) );
        }
        
        if($user instanceof user)
        {
            return $user;
        }
        
        return NULL;
        
    }        
  
    
    /**
     * Create random username
     * @param type $lenght
     * @return type 
     */
    public static function createRandomUsername($lenght = 10)
    {
        $chars   = "QWERTZUIOPASDFGHJKLYXCVBNMasdfghjklqwertzuiopyxcvbnm1234567890";
        $shuffle = str_split($chars);
        shuffle($shuffle);
        $string  = implode("", $shuffle);
        return substr($string, 0, $lenght).time();
    }
    
    /**
     * Validate pasword
     * If is facebook user dont validate password
     * @param type $password
     * @return boolean 
     */
    public function validatePassword($password) 
    {
        if( $this->facebook_cuenta ==  1)
        {
            return true;
        }
        
        return $this->password == self::hash($password);
    }
    
    /**
     * Hash password
     * @param type $password
     * @return type 
     */
    public static function hash($password) 
    {
        return md5($password);
    }    
    
}
