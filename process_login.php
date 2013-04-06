<?php require_once dirname(__FILE__) . '/lib/ldap_utils.php';?>
<?php require_once dirname(__FILE__) . '/model/user.php';?>

<?php include 'view/_header.php' ?>


<?php 
if (!array_key_exists('username', $_POST) || !array_key_exists('passwd', $_POST)) {
?>
<p class="error">Need to provide BOTH username and password to sign in.</p>
<?php 
}

$user = $_POST['username'];
$password = $_POST['passwd'];
list($success, $msg) = ldap_utils::login( $user, $_POST['passwd']);

if ($success) {
	//look up account to see if it is a student or a ta
	
	$results = user::getAll(array("userid"=>$user));
	$user = $results[0];
	echo $user;
	if (ldap_utils::is_valid_login_location() && $user->role == "student"){
		//redirect to add partner
		print "STUDENT";
	} else if ($user->role == "ta" || $user->role == "admin") {
		//redirect to admin page
		print $user->role;
	} else {
		print "Bad Login";
	}

	
} else
	print "<p>Failure: $msg</p>\n";



?>




Welcome!

<?php include 'view/_footer.php' ?>
