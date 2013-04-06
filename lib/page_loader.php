<?php
class page_loader {
	private $controller;
	private $action;
	private $urlvalues;
	
	//store the URL values on object creation
	public function __construct($urlvalues) {
		$this->urlvalues = $urlvalues;
		if (empty($this->urlvalues['c']) || $this->urlvalues['c'] == "") {
			$this->controller = "home";
		} else {
			$this->controller = $this->urlvalues['c'];
		}
		if (empty($this->urlvalues['a']) || $this->urlvalues['a'] == "") {
			$this->action = "index";
		} else {
			$this->action = $this->urlvalues['a'];
		}
	}
	//establish the requested controller as an object
	public function CreateController() {
		//does the class exist?
		if (class_exists($this->controller)) {
			$parents = class_parents($this->controller);
			//does the class extend the controller class?

			if (method_exists($this->controller,$this->action)) {
				return new $this->controller($this->action,$this->urlvalues);
			} else {
				//bad method error
				return new Error("badUrl",$this->urlvalues);
			}
			
		} else {
			//bad controller error
			return new Error("badUrl",$this->urlvalues);
		}
	}
}
?>