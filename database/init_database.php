<?php 
require_once dirname(__FILE__) . '/../lib/student.php';
?>
<html>
<head></head>
<body>


<?php
$test = new student();
$test->drop_table();
$test->create_table();
$test->disconnect();

$bob = new student("'Ted Nugent'", "'tnug'", "'fever'", "'tnug@umail.com'" );
$id = $bob->save();
?>
<h1> <?php echo $id ?></h1>
<?php 

$ted = new student();
$ted->load($id);
?>
<h3> <?php echo $ted->name ?></h3>
<h3> <?php echo $ted->userid ?></h3>
<h3> <?php echo $ted->password ?></h3>
<h3> <?php echo $ted->email ?></h3>
</body>
</html>