<?php
	header("Content-type:application/javascript");
	// incase 'HTTP_HOST' is undefined:
	$default_domain = 'melahi.host56.com'; // put yours in here
	
	// option: override default display id for multiple slide displays 
	$v = array_key_exists('v', $_GET)? $_GET['v']:'slides';
	// glob pattern and can include an additional path, but remove the leading '/'
	$p = array_key_exists('PATH_INFO', $_SERVER)? substr($_SERVER['PATH_INFO'], 1): ($v.'/*.jpg');
// echo "alert(\"p=$p\");\n";
	$p = json_encode(glob($p, GLOB_BRACE+GLOB_MARK)); // mark directories and expand braces, {[pP][nN][gG],[jJ][pP][gG]}
	echo "var images = $p;\n";

	// now get the base path
	$root = array_key_exists('HTTP_HOST', $_SERVER)? $_SERVER['HTTP_HOST']:$default_domain;
	// concatenate avoids it evaluating as numeric
	$root .= array_key_exists('PHP_SELF', $_SERVER)? $_SERVER['PHP_SELF']:'/';
	$root = 'http://' . substr($root, 0, strrpos($root, '/glob-ss.php')+1);
// echo "alert(\"root=$root\");\n"; // diagnostic

	// create a new object for this slideshow
	echo "var $v = new SlideShow(\"$v\", \"$root\", images);\n";
?>