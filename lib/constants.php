<?php
define('WWW_ROOT', dirname(dirname(__FILE__)));
$directory = basename(WWW_ROOT);
$url = explode($directory, $_SERVER['REQUEST_URI']);
if(count($url) == 1){
	define('WEBROOT', DIRECTORY_SEPARATOR);
}else{
	define('WEBROOT', $url[0] . 'portfolio/');
}

define('IMAGES', WWW_ROOT . DIRECTORY_SEPARATOR . 'images');