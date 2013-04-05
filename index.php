<?php include 'view/_header.php' ?>

<h2> Sign in </h2>

<form action="process_login.php" method="POST">
	<p>
	Username:
	<input type="text" id="username" name="username" />
	</p>
	<p>
	Password:
	<input type="password" id="passwd" name="passwd" />
	</p>
	<p>
	<input type="submit" />
	</p>
</form>

<?php include 'view/_footer.php' ?>