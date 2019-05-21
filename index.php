<?php

require 'config.php';
//require UTILS.'auth.php';
//require UTILS.'validator.php';
//require UTILS.'mobile.php';

// Also spl_autoload_register (Take a look at it if you like)
spl_autoload_register ('myautoload');
function myautoload($class) {
	$classes = explode("\\", $class);
	$class = end($classes);
    $path = LIBS . $class .".php";
    if(file_exists($path))
    require LIBS . $class .".php";
    else if(file_exists(UTILS . $class .".php"))
    	require UTILS . $class .".php";
    else {
    	$new_path = OBJS . $class .".php";
    	require $new_path;
    }
}

$bootstrap = new bootstrap();
//$bootstrap->setErrorFile('error.php');
//$bootstrap->setControllerPath('/controllers');
//$bootstrap->setModelPath('/models');
//$bootstrap->setDefaultFile('index.php');
//$bootstrap->setDefaultModelFile('index_model.php');
$bootstrap->init();