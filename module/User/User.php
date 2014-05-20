<?php
/**
 * Created by PhpStorm.
 * User: schmidtgen
 * Date: 19.05.14
 * Time: 10:29
 */
namespace Module\User;
require_once(MODULE_PATH.'/Database/Database.php');
require_once(MODULE_PATH.'/User/UserEntity.php');


use Module\Database\Database;

/**
 * Class User
 * @package Module\User
 */
class User {
    /**
     * @var \Module\Database\Database
     */
    protected $db;
    /**
     * @var array
     */
    protected $dbSchemaMapping = array(
        'id' => 'Id',
        'first_name' => 'FirstName',
        'last_name' => 'LastName',
        'email' => 'Email',
    );
    /**
     * @var string
     */
    protected $dbTableName = 'user';

    /**
     * @return array
     */
    public function getDbSchemaMapping()
    {
        return $this->dbSchemaMapping;
    }


    /**
     *
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * @return array
     */
    public function getUserCollection()
    {
        $users = $this->db->getCollection($this->dbTableName);
        $ret = array();
        if(is_array($users)){
            foreach($users as $user){
                $ret[] = $this->_getUserEntity($user);
            }
        }
        return $ret;
    }

    /**
     * @param $data
     * @return UserEntity
     */
    private function _getUserEntity($data){
        $user = new UserEntity();

        //  Generiert die Settermethoden aus der SchemaConfig
        // ersetzt mir also die einzelnen Aufrufe von setId()
        // in der userEntity
        foreach($data as $key => $value){
            $function = 'set'.$this->dbSchemaMapping[$key];
            $user->$function($value);
        }
        return $user;
    }

    /**
     * @param UserEntity $user
     * @return string
     */
    public function setUser(UserEntity $user){
        $ret = $this->db->insertData($this->dbTableName, $this->dbSchemaMapping, $user);
        return $ret ? ' Nutzer erfolgreich angelegt.' : 'Nutzer konnte nicht angelegt werden.';
    }
} 