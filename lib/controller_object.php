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
	protected function ReturnView($viewmodel,  $fullview, $errors="") {
		$content = 'view/' . get_class($this) . '/' . $this->action . '.php';
		if ($fullview) {
			require('view/maintemplate.php');
		} else {
			require($content);
		}
	}
}

?>