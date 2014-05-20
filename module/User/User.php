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
require_once(MODULE_PATH . '/User/UserHydrator.php');


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
        $hydrator = new UserHydrator();
        return $hydrator->hydrate($data, $user);
    }

    /**
     * @param UserEntity $user
     * @return string
     */
    public function setUser(UserEntity $user){
        $hydrator = new UserHydrator();
        $data = $hydrator->extract($user);
        $ret = $this->db->insertData($this->dbTableName, $data);
        return $ret ? ' Nutzer erfolgreich angelegt.' : 'Nutzer konnte nicht angelegt werden.';
    }
} 