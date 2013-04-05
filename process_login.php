<?php require_once dirname(__FILE__) . '/lib/ldap_utils.php';?>


<?php include 'view/_header.php' ?>


<?php 


if (!array_key_exists('username', $_POST)) {
	print "<p>Need to provide a username to sign in.</p>\n";
	return ;
}
if (!array_key_exists('passwd', $_POST)) {
	print "<p>Need to provide a password to sign in.</p>\n";
	return;
}
$user = $_POST['username'];
$password = $_POST['passwd'];

list($success, $msg) = ldap_utils::login( $user, $_POST['passwd']);
if ($success)
	print "<p>Welcome $msg!</p>\n";
else
	print "<p>Failure: $msg</p>\n";



?>




Welcome!

<?php include 'view/_footer.php' ?>
