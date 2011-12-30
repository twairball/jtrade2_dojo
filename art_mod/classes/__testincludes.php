<?php

define('__ROOT__', dirname(dirname(__FILE__))); 
echo "FILE: ".__FILE__."<br>";
echo "dir(file): ".dirname(__FILE__)."<br>";
echo "dir(dir(file)): ".dirname(dirname(__FILE__))."<br>";

set_include_path(get_include_path() . PATH_SEPARATOR . '/jtrade2/art_mod/includes/');
set_include_path(get_include_path() . PATH_SEPARATOR . '/jtrade2/art_mod/');


?>