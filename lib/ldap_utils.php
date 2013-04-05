<?php
require_once dirname(__FILE__) . '/../config/config.php';

class ldap_utils {
	
	
	static function login( $user, $pswd) {
		if (Config::IS_TEST_ENV) {
			return array(True, "Test User");
			
		}

		$conn = ldap_connect(Config::LDAP_SERVER);
		if (!$conn)
			return array(False, "Could not connect to LDAP server: " . Config::LDAP_SERVER);
	
		ldap_set_option($conn, LDAP_OPT_PROTOCOL_VERSION, 3);
		$bind = ldap_bind($conn, Config::LDAP_RDN, Config::LDAP_PASSWORD);
		if (!$bind)
			return array(False, "Could not bind to the " . Config::LDAP_NAME . " LDAP server.");
	
		if (!($result = ldap_search($conn, Config::LDAP_BASE, "uid=$user", array('cn'))))
			return array(False, "Search failed on the " . Config::LDAP_NAME . " LDAP server.");
		$count = ldap_count_entries($conn, $result);
		if (!$count)
			return array(False, INVALID_LOGIN);
		elseif($count > 1)
		return array(False, 'More than one result returned. Aborting.');
		$entry = ldap_first_entry($conn, $result);
		$attributes = ldap_get_attributes($conn, $entry);
		var_dump($attributes);
		var_dump($entry)
		ldap_free_result($result);
		ldap_unbind($bind);
		if (!($bind = ldap_bind($conn, ldap_get_dn($conn, $entry), $pswd)))
			return array(False, INVALID_LOGIN);
		ldap_unbind($bind);
		return array(True, $attributes['cn'][0]);
	}
	
	
	
}

?>