<?php
//require the general classes
require("lib/page_loader.php");
require_once "model/user.php";
require("model/lab.php");
require("model/attendance.php");
//require the controller classes
require("controllers/home.php");

//process get urls, store them, and create appropriate controller to redirect.
$loader = new page_loader($_GET);
$controller = $loader->CreateController();
$controller->ExecuteAction();

?>