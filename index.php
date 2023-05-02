<?php 


spl_autoload_register(function ($className) {
	$classPath = str_replace('_', '/', $className);
    require_once $classPath . '.php';
});

class Index
{
	
	public static function init()
	{
		$front = new Controller_Core_Front();
		$front->init();
	}

	public static function getModel($className)
	{
		$className = 'Model_'.$className;
		return new $className();
	}

}


$index = new Index();
$index->init();



?>