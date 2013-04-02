<?php
require_once 'config/config.php';

class database_object
{


    static protected $dbconn;
    static protected $tablename;
    static protected $field_list;

    
    function database_object( ){
    }

    function select($where) {
        try{
            $select_sql = "SELECT " . implode(", ", array_keys($this->field_list)) . " FROM " . $this->tablename 
                            . "WHERE $where";

            return $this->dbconn->query($select_sql);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            echo $select_sql;
        }
    }

    function insert($values) {
        try{
            $insert_sql = "INSERT INTO $this->tablename (" . implode(", ", array_keys($values)) . 
                          ") VALUES (" . implode(", ", array_values($values)) . ")" ;

            $stmt = $this->dbconn->prepare($insert_sql);
            $stmt->execute();

        }
        catch(PDOException $e) {
            echo $e->getMessage();
            echo $insert_sql;
        }
    }

    //creates the tables, mainly used in init scripts
    static function create_table() {
        try{
            $create_sql = "CREATE TABLE IF NOT EXISTS " . $this->tablename . "( ";

            $out = array();
            foreach ($this->field_list as $name => $type) {
                 $out[] = "$name $type";
            }
            $create_sql .= implode(", ", $out) . ")";

            $this->dbconn->exec("$create_sql");
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            echo $create_sql;
        }
    }

    //creates the tables, mainly used in init scripts
    static function drop_table() {
    	try{
    		$create_sql = "DROP TABLE IF EXISTS " . $this->tablename ;
       
    		$this->dbconn->exec("$create_sql");
    	}
    	catch(PDOException $e) {
    		echo $e->getMessage();
    		echo $create_sql;
    	}
    }
    
    
    
    static function connect() {
        try{
        	if ($this->dbconn == null) {
	            // Create (connect to) SQLite database in file
	            $this->dbconn = new PDO('sqlite:' . $DB_NAME);
	            // Set errormode to exceptions
	            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, 
	                                    PDO::ERRMODE_EXCEPTION);
        	}
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }
    }

    static function disconnect() {
        try{
            // Close file db connection
            $this->dbconn = null;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
        }

    }



}
?>

