<?php
function __autoload($class)
{
	$class = str_replace('\\', '/', $class);
	$class = preg_replace('/([a-z])([A-Z])/', '$1-$2', $class);
	$class = mb_strtolower($class);
  require __DIR__ . '/../' . $class . '.php';
}
