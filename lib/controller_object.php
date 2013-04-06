<?php 


abstract class controller_object {
	protected $urlvalues;
	protected $action;
	public function __construct($action, $urlvalues) {
		$this->action = $action;
		$this->urlvalues = $urlvalues;
	}
	public function ExecuteAction() {
		return $this->{$this->action}();
	}
	protected function ReturnView($data,  $fullview, $errors="") {
		$ctrllr_str =  str_replace( "_controller", "", get_class($this));
		$content = 'view/' . $ctrllr_str . '/' . $this->action . '.php';
		if ($fullview) {
			require('view/maintemplate.php');
		} else {
			require($content);
		}
	}
}

?>