<?php
ini_set("display_errors",1);
error_reporting(E_ALL);
require(__DIR__ . '/core/autoload.php');
use Core\DC\DC;
DC::Run();
