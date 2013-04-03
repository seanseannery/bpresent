<?php
include dirname(__FILE__) . '/../config/config.php';

class database_object
{


    protected $dbconn;
    protected $tablename;
    protected $field_list;   //key= col name, val= col type
    protected $record_values; //key= col name, val=db value
    
 	public function __set($name, $value)
    {
    	if (array_key_exists($name, $this->record_values)) {
        	$this->record_values[$name] = $value;
    	} else {	
    		$trace = debug_backtrace();
    		trigger_error(
    				'Undefined property via __set(): ' . $name .  ' in ' . $trace[0]['file'] .
    				' on line ' . $trace[0]['line'], E_USER_NOTICE);
    		return null;
    	}
    }

    public function __get($name)
    {
        if (array_key_exists($name, $this->record_values)) {
            return $this->record_values[$name];
        } else {

	        $trace = debug_backtrace();
	        trigger_error(
	            'Undefined property via __get(): ' . $name .  ' in ' . $trace[0]['file'] .
	            ' on line ' . $trace[0]['line'], E_USER_NOTICE);
	        return null;
        }
    }

    function database_object(){
    	$this->field_list =array("id" => "INTEGER PRIMARY KEY");
    	$this->record_values = array("id" => "NULL");
    }

    function load($id){
    	$result = $this->select("id = $id");
    	
    	foreach ($result as $r){
    		$this->record_values = $r;
    	}
    }
    
    function select($where) {
    	$this->connect();
    	
        try{
            $select_sql = "SELECT " . implode(", ", array_keys($this->field_list)) . " FROM " . $this->tablename  
                            . " WHERE $where";

            return $this->dbconn->query($select_sql);
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            echo $select_sql;
        }
    }

    function save() {
    	$this->connect();
    	
        try{
        	
        	$key_value_pairs = array();
        	foreach ($this->record_values as $name => $data) {
        		if ($name != "id"){
        			$key_value_pairs[] = "$name = $data";
        		}
        	}
        	
        	//insert a new record
        	if ($this->id == "NULL"){
	            $sql = "INSERT INTO $this->tablename  (" . implode(", ", array_keys($this->record_values)) . 
	                          ") VALUES (" . implode(", ", array_values($this->record_values)) . ")" ;
	
	            $stmt = $this->dbconn->prepare($sql);
	            $stmt->execute();
	            
	            //populate id
	            $sql = 'SELECT id FROM '.$this->tablename.' WHERE ' . implode(" AND ", $key_value_pairs);
	            $result = $this->dbconn->query($sql);
	            foreach ($result as $m) {
	            	$this->id = $m["id"];
	            }
	            
	            return $this->id;
	            
        	} else {
        	//update an existing record

        		
        		$sql = "UPDATE $this->tablename SET (" . implode(", ", $key_value_pairs) . " WHERE ID = " . $this->id;
        	
        		$stmt = $this->dbconn->prepare($sql);
        		$stmt->execute();
        		
        		return $this->id;
        		
        	}

        }
        catch(PDOException $e) {
            echo $e->getMessage();
            echo $sql;
        }
    }

    //creates the tables, mainly used in init scripts
    function create_table() {
    	$this->connect();
    	
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
    function drop_table() {
    	$this->connect();
    	
    	try{
    		$drop_sql = "DROP TABLE IF EXISTS " . $this->tablename  ;

    		$this->dbconn->exec($drop_sql);
    	}
    	catch(PDOException $e) {
    		echo $e->getMessage();
    	
    		echo $drop_sql;
    	}
    }
    
    
    
    function connect() {
        try{
        	if ($this->dbconn == null) {
	            // Create (connect to) SQLite database in file
	            $this->dbconn = new PDO('sqlite:' . config::DB_NAME);
	            // Set errormode to exceptions
	            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, 
	                                    PDO::ERRMODE_EXCEPTION);
        	}
        }
        catch(PDOException $e) {
            echo "Error connecting \n" . $e->getMessage() ."\n". $e->getTrace();
        }
    }

    function disconnect() {
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

