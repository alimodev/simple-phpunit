<?php

/**
 * Loading UnitTest classes
 */
spl_autoload_register(function($className){
	$className = explode('\\', $className);
  $className = end($className);
	$classFile = __DIR__ . DIRECTORY_SEPARATOR . $className . '.class.php';
	if (file_exists($classFile))
	{
		require_once($classFile);
	}
});
