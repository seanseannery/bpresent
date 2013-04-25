<?php
//require the general classes
require("lib/page_loader.php");
require("controllers/home.php");
require_once "model/user.php";
require("model/lab.php");
require("controllers/lab.php");
require("model/attendance.php");




//process get urls, store them, and create appropriate controller to redirect.
$loader = new page_loader($_REQUEST);
$controller = $loader->CreateController();
$controller->ExecuteAction();

?>
