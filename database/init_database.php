<?php 

require_once dirname(__FILE__) . '/../lib/student.php';
Student::connect();
Student::drop_table();
Student::create_table();
Student::disconnect();



?>