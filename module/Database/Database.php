<?php
/**
 * Created by PhpStorm.
 * User: schmidtgen
 * Date: 19.05.14
 * Time: 10:30
 */

namespace Module\Database;


use mysqli;

/**
 * Class Database
 * @package Module\Database
 */
class Database {

    /**
     * Konfiguration für Datenbankverbindung
     * @var array
     */
    protected $dbConfig = array(
        'host' => 'localhost',
        'user' => 'testmartin',
        'password' => 'testpasswort',
        'database' => 'testaufgabe'
    );

    /**
     * Datenbankverbindung
     * @var \mysqli|null
     */
    protected $db = null;

    /**
     * Konstruktor- DB-Verbindung wird aufgebaut
     * @throws \Exception
     */
    public function __construct()
    {
        // Verbindung zur Datenbank herstellen
        $this->db = new mysqli($this->dbConfig['host'],$this->dbConfig['user'],$this->dbConfig['password'],$this->dbConfig['database']);
        if(mysqli_connect_errno()){
            throw new \Exception('Verbindung fehlgeschlagen: %s\n'.mysqli_connect_error());
        }
    }

    /**
     * Destruktor
     * DB-Verbidung wird geschlossen
     */
    public function __destruct(){
        $this->db->close();
    }

    /**
     * Holte eine Kollektion aus der Datenbank
     * @param $table string Tabellenname
     * @return array|bool
     */
    public function getCollection($table)
    {
        $sql = 'SELECT * FROM '.$table;
        $result = $this->db->query($sql);
        if($result){
            $ret = array();
            while($data =  $result->fetch_assoc()){
                $ret[] = $data;
            }
            $result->close();
            return $ret;
        }else{
            return false;
        }
    }

    /**
     * Speichert einen Datensatz in der Datenbank
     * @param $table string Tabellenname
     * @param array $data
     * @return bool|\mysqli_result
     */
    public function insertData($table, array $data)
    {
        $fieldCount = count($data);
        $sql = "INSERT INTO ".$table." ( ";
        $i = 1;
        $inserts = '';
        foreach ($data as $field => $content) {
            if ($i == $fieldCount) {
                $separator = " ";
                $insertSeparator = "' ";
            } else {
                $separator = ", ";
                $insertSeparator = "', ";
            }
            $sql .= $field . $separator;
            $inserts .= "'" . $content . $insertSeparator;

            $i++;
        }
        $sql .= ") VALUES ( ".$inserts.")";

        return $this->db->query($sql);

    }

    
} 