<?php
require_once dirname(__FILE__) . '/../lib/controller_object.php';
require_once dirname(__FILE__) . '/../lib/ldap_utils.php';

class lab_controller extends controller_object {
	protected function Index() {
		$lab = new lab();
		if (!empty($this->urlvalues['id'])){
			$lab = $lab->getByID($this->urlvalues['id']);
		}
		$this->ReturnView($lab, true);
	}
	
	protected function Edit() {
		$lab = new lab();
		if (!empty($this->urlvalues['id'])){
			$lab = $lab->getByID($this->urlvalues['id']);
		}
		$this->ReturnView($lab, true);
	}
	
	protected function Destroy() {
		$lab = new lab();
		if (!empty($this->urlvalues['id'])){
			$lab = $lab->getByID($this->urlvalues['id']);
		}
		$lab->destroy();
		
		$home = new home_controller('admin', $this->urlvalues);
		$home->ReturnView(null, true);
	}
	
	protected function Save() {

		
		$lab = new lab( $this->urlvalues['name'], $this->urlvalues['time'], $this->urlvalues['tas'], 
									$this->urlvalues['quarter'], $this->urlvalues['year'], $this->urlvalues['id']);
		$lab->save();
		
		if (!empty($this->urlvalues['id'])){
			$lab = $lab->getByID($this->urlvalues['id']);
		}
		$home = new home_controller('admin', $this->urlvalues);
		$home->ReturnView(null, true);
	}
	
}

?>