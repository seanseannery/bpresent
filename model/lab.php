<?php 
require_once dirname(__FILE__) . '/../lib/database_object.php';

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
	
    
    function lab( $name="", $time="", $tas="", $qtr="", $id="NULL")
    {
    	$this->init();
    	$this->id = $id;
    	$this->classname = $name;
    	$this->labtime = $time;
    	$this->tas = $tas;
    	$this->quarter = $qtr;
    }
    

}

?>
