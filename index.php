<?php

//print_r($_GET['url']);

//separador de directorios
//    linux /
//    windows \

define("DS", DIRECTORY_SEPARATOR);
define("ROOT", realpath(dirname(__FILE__)).DS);
define("APP_PATH", ROOT."aplication".DS);


//carga los archivos necesarios para iniciar la aplicacion 
require_once(APP_PATH."Config.php");
require_once(APP_PATH."Request.php");
require_once(APP_PATH."Bootstrap.php");
require_once(APP_PATH."Controller.php");
require_once(APP_PATH."Model.php");
require_once(APP_PATH."View.php");
require_once(APP_PATH."Database.php");
require_once(APP_PATH."Autoload.php");

//echo "<pre>"; print_r(get_required_files());



try{

	Bootstrap::run(new Request);

}catch (Exception $e){

	echo $e->getMessage();

}




?>


