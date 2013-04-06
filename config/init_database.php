<?php 
require_once dirname(__FILE__) . '/../config/config.php';
require_once dirname(__FILE__) . '/../model/user.php';
require_once dirname(__FILE__) . '/../model/lab.php';
?>
<html>
<head></head>
<body>

<h4>Creating Lab Table</h4>
<?php 
$init = new lab();
$init->drop_table();
$init->create_table();
$init->disconnect();
?>
<h4>Creating User Table</h4>
<?php
$init = new user();
$init->drop_table();
$init->create_table();
$init->disconnect();
?>
<h4>Creating Admins</h4>
<?php 
$admin = new user("Sean Maloney", "sean",  "sean@cs.ucsb.edu", "admin" );
$admin->save();
?>

<?php
//if test env add a bunch of test data to play with 
if (Config::IS_TEST_ENV)
{
	echo "<h4>Testing...</h4>";
	
	$lab1 = new lab("CS56", "1pm", "", "W", "2013");
	$lab1->save();
	
	$u1 = new user("Ted Nugent", "tnug",  "tnug@umail.com", "student" );
	$id = $u1->save();
	$u1->email = 'theodore@nugget.com';
	$u1->save();
	
	print "id: $id <br/>";
	
	$ted = new user();
	// echo $ted . "<br/>";

	$ted = $ted->getByID($id);

    echo $ted . "<br/>";
    echo $lab1 . "<br/>";
  
    $ted->destroy();
 
}
 ?>
</body>
</html>