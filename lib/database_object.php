<?php
require_once dirname(__FILE__) . '/../config/config.php';

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


    
    public function load_by_row($row_array){
    	$this->record_values = $row_array;
    }
    
    static function getByID($id){
    	$classname = get_called_class();
    	$instance = new $classname();
    	$row = $instance->select(array("id" => $id));
    	foreach ($row as $r){
    		$instance->load_by_row($r);
    	}
   	
    	return $instance;

    }
    
    static function getAll($where=null){
    	
    	$classname = get_called_class(); 
    	$instance = new $classname();
    	
    	$rows = $instance->select($where);
    	
    	$results = array();
    	foreach ($rows as $r) {
    		$temp = new $classname();
    		$temp->load_by_row($r);
    		$results[] = $temp;
    	}
    	return $results;
    }
    
    function select($where, $orderby="") {
    	$this->connect();
    	
        try{
        	$where_sql = "";
        	if (!empty($where)){
        		
        		$key_value_pairs = array();
        		foreach ($where as $name => $data) {
        				$key_value_pairs[] = "$name = :$name";

        		}
        		$where_sql = " WHERE " . implode(" AND ", $key_value_pairs);
        		
        	}
        	$orderby_sql = "";
        	if (!empty($orderby)){
        		$orderby_sql = " ORDER BY " . $orderby;
        	}
            $select_sql = "SELECT " . implode(", ", array_keys($this->field_list))
                            . " FROM " . $this->tablename  
                            . $where_sql
                            . $orderby_sql;
                      
            
            $stmt = $this->dbconn->prepare($select_sql);
           
            if (isset($where))
	            foreach($where as $key=>$value){
	            	$stmt->bindValue(":$key", $value);
	            }
	            
            $results = array();
            if ($stmt->execute()) {
            	while ($row = $stmt->fetch()) {
            		
            		$results[] = array_intersect_key( $row, $this->record_values);
            		
            	}
            }

            return $results;
        }
        catch(PDOException $e) {
            echo $e->getMessage();
            echo $select_sql;
            echo "<pre>";
            //$stmt->debugDumpParams();
            echo "</pre>";
        }
    }

    function destroy() {
    	$this->connect();
    	 
    	try{
    		$sql = "DELETE FROM  $this->tablename WHERE id = ?";
    
    		$stmt = $this->dbconn->prepare($sql);
            $stmt->execute(array($this->record_values["id"]));
    	}
    	catch(PDOException $e) {
    		echo $e->getMessage();
    		echo $sql;
   		 }
   		 
   		 $this->record_values['id'] = "NULL";
   		 $this->disconnect();
  	}
    
    function save() {
    	$this->connect();
    	
        try{
        	
        	$where_place_holders = array();
        	foreach ($this->record_values as $key => $value) {
        		if ($key != "id"){
        			$where_place_holders[] = "$key = :$key";
        		}
        	}
        	        	
        	//insert a new record
        	if ($this->id == "NULL"){
        		$insert_place_holders = array();
        		foreach($this->record_values as $key=>$value){
        			if ($value != "NULL" || !empty($value)){
        				$insert_place_holders[$key] = ":$key";
        			}
        		}
        		
	            $sql = "INSERT INTO $this->tablename  (" . implode(", ", array_keys($insert_place_holders)) . 
	                          ") VALUES (" . implode(", ", $insert_place_holders) . ")";
	            $stmt = $this->dbconn->prepare($sql);
	            
	            foreach($this->record_values as $key=>$value){
	            	if ($value != "NULL" && !empty($value)){
		            	$stmt->bindValue(":$key", $value);
	            	}
	            }
	           
	            $stmt->execute();
	            
	            //populate id
	            $sql = 'SELECT id FROM '.$this->tablename.' WHERE ' . implode(" AND ", $where_place_holders);
	            $stmt = $this->dbconn->prepare($sql);
	            
	            foreach($this->record_values as $key=>$value){
	            	if ($value != "NULL" && !empty($value)){
		            	$stmt->bindValue(":$key", $value);
	            	}
	            }
	            
	            if ($stmt->execute()) {
	            	while ($row = $stmt->fetch()) {
	            		$this->id = $row["id"];
	            	}
	            }
	            	            
	            return $this->id;
	            
        	} else {
        	//update an existing record

        		
        		$sql = "UPDATE $this->tablename SET " . implode(", ", $where_place_holders) . " WHERE ID = " . $this->id;
        	
        		$stmt = $this->dbconn->prepare($sql);
        		foreach($this->record_values as $key=>$value){
        			if ($key != "id"){
        				$stmt->bindValue(":$key", $value);
        			}
        		}
        		$stmt->execute();
        		
        		return $this->id;
        		
        	}

        }
        catch(PDOException $e) {
            echo $e->getMessage();
            echo "<pre>";
            $stmt->debugDumpParams();
            echo "</pre>";
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
	            $this->dbconn = new PDO('sqlite:' . config::DB_NAME());
	            // Set errormode to exceptions
	            $this->dbconn->setAttribute(PDO::ATTR_ERRMODE, 
	                                    PDO::ERRMODE_EXCEPTION);
	            
        	}
        }
        catch(PDOException $e) {
            echo "Error connecting \n" . $e->getMessage() ."\n". $e->getTrace();
            echo "<pre>" . var_dump($this) . "</pre>";
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
    

	function __destruct(){
		$this->disconnect();
	}
	
	function __toString() {
		$return_val = "";
		foreach ($this->record_values as $key=>$value){
			$return_val .= "$key=$value, ";
		}
		return get_class($this) . "[" . $return_val . "]";
		
	}

}
?>

