<?php 
include_once dirname(__FILE__) . '/../model/lab.php';
?>
<html>
<head></head>
<body>
	<h1>Lab Attendance Administration</h1>
	<h3>Labs</h3>
	<table>
		<tr>
			<th>Quarter</th> <th>Class</th> <th>Lab</th>
		</tr>

<?php

$labs = lab::getAll();
foreach($labs as $lab){
?>
		 <tr>
		 	<td><?= $lab->quarter ?></td> <td><?= $lab->classname ?></td> <td><?= $lab->labtime ?></td>
		 </tr>

 <?php 	
}
?>

		
	</table>


</body>
</html>