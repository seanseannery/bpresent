<?php
$labs = lab::getAll();
$admins = user::getAll(array('role'=>'admin'));
$tas = user::getAll(array('role'=>'ta'));
$all_admins = array_merge($admins, $tas);
$students = user::getAll(array('role'=>'student'));

?>

	<h2>Administration</h2>
	<h3>Labs</h3>
	<table>
		<tr>
			<th>Quarter</th> <th>Class</th> <th>Lab</th>
		</tr>
<?php 
foreach($labs as $lab){
?>
		 <tr>
		 	<td><?= $lab->quarter ?></td> <td><?= $lab->classname ?></td> <td><?= $lab->labtime ?></td>
		 </tr>

 <?php 	
}
?>		
	</table>
	
	
	<h3>Admins</h3>	
	<table>
		<tr>
			<th>Name</th> <th>UserID</th> <th>Email</th> <th>Role</th>
		</tr>
<?php 
foreach($all_admins as $user){
?>
		 <tr>
		 	<td><?= $user->name ?></td> <td><?= $user->userid ?></td> <td><?= $user->email ?></td> <td><?= $user->role ?></td>
		 </tr>

 <?php 	
}
?>		
	</table>
	
	<h3>Students</h3>	
	<table>
		<tr>
			<th>Name</th> <th>UserID</th> <th>Email</th> <th>Role</th>
		</tr>
<?php 
foreach($students as $user){
?>
		 <tr>
		 	<td><?= $user->name ?></td> <td><?= $user->userid ?></td> <td><?= $user->email ?></td> <td><?= $user->role ?></td>
		 </tr>

 <?php 	
}
?>		
	</table>


</body>
</html>