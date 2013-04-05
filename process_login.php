<?php include 'includes/_header.php' ?>


<?php 


if (!array_key_exists('username', $_POST)) {
	print "<p>Invalid form.</p>\n";
	return ;
}
if (!array_key_exists('passwd', $_POST)) {
	print "<p>Invalid form.</p>\n";
	return;
}
$user = $_POST['username'];
$password = $_POST['passwd'];

$config = array('server' => 'ldaps://accounts.cs.ucsb.edu:636',
		'rdn' => 'uid=nssldap,ou=people,dc=engr,dc=ucsb,dc=edu',
		'password' => 'buMps3tSp1ke',
		'base' => 'dc=engr,dc=ucsb,dc=edu',
		'name' => 'College of Engineering');

list($success, $msg) = login($config, $user, $_POST['passwd']);
if ($success)
	print "<p>Welcome $msg!</p>\n";
else
	print "<p>Failure: $msg</p>\n";



function login($conf, $user, $pswd) {
	$conn = ldap_connect($conf['server']);
	if (!$conn)
		return array(False, "Could not connect to LDAP server: ${conf['name']}");

	ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
	$bind = ldap_bind($conn, $conf['rdn'], $conf['password']);
	if (!$bind)
		return array(False, "Could not bind to the ${conf['name']} LDAP server.");

	if (!($result = ldap_search($conn, $conf['base'], "uid=$user", array('cn'))))
		return array(False, "Search failed on the ${conf['name']} LDAP server.");
	$count = ldap_count_entries($conn, $result);
	if (!$count)
		return array(False, INVALID_LOGIN);
	elseif($count > 1)
	return array(False, 'More than one result returned. Aborting.');
	$entry = ldap_first_entry($conn, $result);
	$attributes = ldap_get_attributes($conn, $entry);
	ldap_free_result($result);
	ldap_unbind($bind);
	if (!($bind = ldap_bind($conn, ldap_get_dn($conn, $entry), $pswd)))
		return array(False, INVALID_LOGIN);
	ldap_unbind($bind);
	return array(True, $attributes['cn'][0]);
}

?>




Welcome!

<?php include 'includes/_footer.php' ?>