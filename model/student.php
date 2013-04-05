<?php 
require_once dirname(__FILE__) . '/database_object.php';

class student extends database_object {

	private function init() 
	{
		$this->tablename = "students";
		$this->field_list =array(
				"id" => "INTEGER PRIMARY KEY",
				"name" => "TEXT",
				"userid" => "USERID",
				"password" => "TEXT",
				"email" => "TEXT");
		$this->record_values = array(
				"id" => "NULL",
				"name" => "",
				"userid" => "",
				"password" => "",
				"email" => "");
	}
	
    
    function student($name="", $uid="", $pw="", $email="")
    {
    	$this->init();
    	$this->name = $name;
    	$this->userid = $uid;
    	$this->password = $pw;
    	$this->email = $email;
    }


}

?>
