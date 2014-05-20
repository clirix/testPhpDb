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
     * Datenbankverbindung
     * @var \Module\Database\Database
     */
    protected $db;

    /**
     * Name der Datenbanktabelle
     * @var string
     */
    protected $dbTableName = 'user';


    /**
     * Konstruktor
     * Bei Aufruf wird Verbindung zur Datenbank aufgebaut
     */
    public function __construct()
    {
        $this->db = new Database();
    }

    /**
     * Holte alle Nutzer aus der Datenbank
     * und gibt ein Array aus Nutzerentitäten zurück
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
     * Erstellt das ÜbergabeObjekt für den Hydrator
     * und gibt einzelne Nutzerentität zurück
     * @param $data
     * @return UserEntity
     */
    private function _getUserEntity($data){
        $user = new UserEntity();
        $hydrator = new UserHydrator();
        return $hydrator->hydrate($data, $user);
    }

    /**
     * Übergibt einen neue Nutzerentität
     * nach umwandlung zum Array der Datenbank zum Speichern
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