<?php 
require_once 'lib/database_object.php';

class student extends database_object {



    function student()
    {
        
        $tablename = "students";
        $field_list =array(
        				"id" => "INTEGER PRIMARY KEY",
        				"name" => "TEXT",
        				"userid" => "USERID", 
        				"password" => "TEXT",
        				"email" => "TEXT");
        
    }


}

?>