<?php


$mod_path = dirname(dirname(__FILE__));
$base_path = dirname($mod_path);
$includes_path = dirname(__FILE__);
$classes_path = $mod_path."\\classes\\";

set_include_path(get_include_path() . PATH_SEPARATOR . $base_path);
set_include_path(get_include_path() . PATH_SEPARATOR . $base_path."\\classes\\");
set_include_path(get_include_path() . PATH_SEPARATOR . $base_path."\\includes\\");
set_include_path(get_include_path() . PATH_SEPARATOR . $mod_path);
set_include_path(get_include_path() . PATH_SEPARATOR . $includes_path);
set_include_path(get_include_path() . PATH_SEPARATOR . $classes_path);

?>