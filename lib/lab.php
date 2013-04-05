<?php 
require_once dirname(__FILE__) . '/database_object.php';

class lab extends database_object {

	private function init() 
	{
		$this->tablename = "labs";
		$this->field_list =array(
				"id" => "INTEGER PRIMARY KEY",
				"classname" => "TEXT",
				"quarter"=> "TEXT",
				"labtime" => "TEXT",
				"tas" => "TEXT");
		$this->record_values = array(
				"id" => "NULL",
				"classname" => "",
				"quarter"=> "",
				"labtime" => "",
				"tas" => "");
	}
	
    
    function lab($id="NULL", $name="", $time="", $tas="", $qtr="")
    {
    	$this->init();
    	$this->id = $id;
    	$this->classname = $name;
    	$this->labtime = $time;
    	$this->tas = $tas;
    	$this->quarter = $qtr;
    }
    
    static function getAll($where=""){
    	$lab = new lab();
    	$values = $lab->select($where);
    	$results = array();
    	foreach ($values as $m) {
    		$results[] = new lab($m["id"], $m["classname"], $m["labtime"], $m["tas"], $m["quarter"] );
    	}
    	return $results;
    }


}

?>