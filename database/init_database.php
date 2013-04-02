<?php 
require_once 'config/config.php';
require_once 'lib/student.php';
Student::connect();
Student::drop_table();
Student::create_table();
Student::disconnect();



?>