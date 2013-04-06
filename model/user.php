<?php 
require_once dirname(__FILE__) . '/../lib/database_object.php';

class user extends database_object {

	private function init()
	{
		$this->tablename = "users";
		$this->field_list =array(
				"id" => "INTEGER PRIMARY KEY",
				"name" => "TEXT",
				"userid" => "TEXT",
				"email" => "TEXT",
				"role" => "TEXT");
		$this->record_values = array(
				"id" => "NULL",
				"name" => "",
				"userid" => "",
				"email" => "",
				"role" => "");
	}


	function user($name="", $uid="", $email="", $role="", $id="NULL")
	{
		$this->init();
		$this->id = $id;
		$this->name = $name;
		$this->userid = $uid;
		$this->email = $email;
		$this->role = $role;
	}

}

?>
