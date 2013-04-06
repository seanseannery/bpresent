<?php
$temp = new lab();
$labs = $temp->getAll(null, 'classname ASC');
$temp = new user();
$admins = $temp->getAll(array('role'=>'admin'));
$tas = $temp->getAll(array('role'=>'ta'));
$all_admins = array_merge($admins, $tas);
$students = $temp->getAll(array('role'=>'student'));

?>

	<h2>Administration</h2>
	<h3>Labs</h3>
	<table>
		<tr>
			<th>Quarter</th> <th>Class</th> <th>Lab</th> <th> TAs </th> <th> edit </th>
		</tr>
<?php 
foreach($labs as $lab){
?>
		 <tr>
		 	<td><?= $lab->quarter ?> <?= $lab->year ?></td> <td><?= $lab->classname ?></td> 
		 	<td>
		 	<a href="?c=lab&id=<?= $lab->id ?>"><?= $lab->labtime ?></a>
		 	</td> 	 <td><?= $lab->tas ?></td>
		 	 <td> <a href="?c=lab&a=edit&id=<?= $lab->id ?>">Edit</a> </td>
		 </tr>

 <?php 	
}
?>		
	</table>
	<form>
	<input type="submit" value="Add New Lab" />
	<input type="hidden" name="a" value="edit" />
	<input type="hidden" name="c" value="lab" />
	 
	</form>
	
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