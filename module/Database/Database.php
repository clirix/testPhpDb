<?php
/**
 * Created by PhpStorm.
 * User: schmidtgen
 * Date: 19.05.14
 * Time: 10:30
 */

namespace Module\Database;


use mysqli;

class Database {

    protected $dbConfig = array(
        'host' => 'localhost',
        'user' => 'testmartin',
        'password' => 'testpasswort',
        'database' => 'testaufgabe'
    );

    protected $db = null;

    public function __construct()
    {
        // Verbindung zur Datenbank herstellen
        $this->db = new mysqli($this->dbConfig['host'],$this->dbConfig['user'],$this->dbConfig['password'],$this->dbConfig['database']);
        if(mysqli_connect_errno()){
            throw new \Exception('Verbindung fehlgeschlagen: %s\n'.mysqli_connect_error());
        }
    }

    public function __destruct(){
        $this->db->close();
    }

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

    public function insertData($table, array $data)
    {
        $fields = array_keys($data);
        $fieldCount = count($fields);
        $sql = "INSERT INTO ".$table." ( ";
        $i = 1;
        $inserts = '';
        foreach ($data as $field => $content) {
                if($i == $fieldCount){
                    $separator = " ";
                    $insertSeparator = "' ";
                }else{
                    $separator = ", ";
                    $insertSeparator = "', ";
                }
                $sql .= $field.$separator;

            $inserts .= "'" . $content . $insertSeparator;

                $i++;
        }
        $sql .= ") VALUES ( ".$inserts.")";

        return $this->db->query($sql);

    }

    
} 