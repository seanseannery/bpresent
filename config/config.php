<?php
// Connection's Parameters
class config{
	
	//you can change the location of the data file if you want
	const DB_NAME =  "../database/attendance_tracker.sqlite";
	
	//populate these fields with your ldap connection info.
	const LDAP_SERVER = 'ldaps://';
	const LDAP_RDN = 'uid=,ou=,dc=';
	const LDAP_PASSWORD = '';
	const LDAP_BASE = 'dc=';
	const LDAP_NAME = '';
	
	//turns off ldap server when testing locally
	const IS_TEST_ENV = true;
	
}
?>
