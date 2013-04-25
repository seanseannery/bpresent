<?php
// Connection's Parameters
class config{
	
	//you can change the location of the data file if you want
	private static $DB_NAME = "/database/attendance_tracker.sqlite";
	
	//populate these fields with your database
	const LDAP_SERVER = 'ldaps://accounts.cs.ucsb.edu:636';
	const LDAP_RDN = 'uid=nssldap,ou=people,dc=engr,dc=ucsb,dc=edu';
	const LDAP_PASSWORD = 'buMps3tSp1ke';
	const LDAP_BASE = 'dc=engr,dc=ucsb,dc=edu';
	const LDAP_NAME = 'College of Engineering';
	
	//turns off ldap server when testing locally
	const IS_TEST_ENV = false;
	
	//populate this array with valid ip/computers students are allowed to log in to
	public static $VALID_LOCATIONS = array();
	
	//this is your csil account name that will only be used in init_database.php
	const ADMIN_USERNAME = 'sean';
	
	public static function DB_NAME(){
		return dirname(__FILE__) . "/.." . self::$DB_NAME;
	}
	
	
}
?>
