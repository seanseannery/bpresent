<?php
require_once dirname(__FILE__) . '/../lib/controller_object.php';
require_once dirname(__FILE__) . '/../lib/ldap_utils.php';

class home extends controller_object {
	protected function Index() {
		
		$this->ReturnView(null, true);
	}
	
	protected function addpartner() {
	
		$this->ReturnView(null, true);
	}
	
	protected function Admin() {
	
		$this->ReturnView(null, true);
	}
	
	protected function Login() {
		
		
		if (empty($this->urlvalues['username'])  || empty($this->urlvalues['passwd'])) {				
			$errors = "Need to provide BOTH username and password to sign in.";
			$this->action = "index";
			$this->ReturnView(null, true, $errors);
			return;	
		}
		
	
		$user = $_GET['username'];
		$password = $_GET['passwd'];
		//msg is user name if successful and error msg if no
		list($success, $msg) = ldap_utils::login( $user, $password);
		
		if ($success) {
			//look up account to see if it is a student or a ta
			$temp = new user();	
			$results = $temp->getAll(array("userid"=>$user));
				
			if (sizeof($results) < 1){
				//user doesnt exist in our system, add them as a student
				$user = new user($msg, $user,  "$user@cs.ucsb.edu", "student" );
				$user->save();
			}else {
				//user exists in system,
				$user = $results[0];
			}
			
			if (ldap_utils::is_valid_login_location() && $user->role == "student"){
				//redirect to add partner
				$this->action = "addpartner";
				$this->ReturnView($user, true);
			} else if ($user->role == "ta" || $user->role == "admin") {
				//redirect to admin page
				$this->action = "admin";
				$this->ReturnView($user, true);
			} else {
				$errors = "Bad Login";
				$this->action = "index";
				$this->ReturnView(null, true, $errors);
				return;
			}
			
			
		} else {
			$errors = "Bad Login: $msg"; 
			$this->action = "index";
			$this->ReturnView(null, true, $errors);
			return;
		}
	
		
			
		
	}
}

?>