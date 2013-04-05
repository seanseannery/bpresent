<?php 
require_once dirname(__FILE__) . '/../lib/student.php';
require_once dirname(__FILE__) . '/../lib/lab.php';
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
<h4>Creating Student Table</h4>
<?php
$init = new student();
$init->drop_table();
$init->create_table();
$init->disconnect();
?>
<h4>Testing...</h4>
<?php 
$test = new student("'Ted Nugent'", "'tnug'", "'fever'", "'tnug@umail.com'" );
$id = $test->save();
$test2 = new lab("NULL","'CS56'", "'1pm'", "''", "'W13'");
$test2->save();

print "id: $id <br/>";

$ted = new student();
$ted->load($id);

  echo "name: $ted->name <br/>"; 
  echo "id: $ted->userid <br/>"; 
  echo "pw: $ted->password <br/>"; 
  echo "email: $ted->email <br/>"; 
  
 $ted->destroy();
 ?>
</body>
</html>