<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>Lab Attendance Tracker</title>
    <link rel="stylesheet" type="text/css" href="scripts/style.css">
</head>

<body>
<header>
	<h1>Lab Attendance Tracker</h1>
</header>

<?php if (isset($errors)){ ?>
	<p class="error"><?php echo $errors ?></p>
<?php } ?>


<?php require($content); ?>


<footer>
If you have problems logging in, contact your TA... If you are a TA, contact the leadTA.
</footer>
</body>
</html>