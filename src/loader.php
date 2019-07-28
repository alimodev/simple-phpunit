<?php

/**
 * Loading UnitTest classes
 */
spl_autoload_register(function($className){
	// removing the namespace
	$className = explode('\\', $className);
  $className = end($className);
	// adding dir and ext
	$classFile = __DIR__ . DIRECTORY_SEPARATOR . $className . '.class.php';
	if (file_exists($classFile))
	{
		require_once($classFile);
	}
});
