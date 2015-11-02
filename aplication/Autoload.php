<?php
/**
 * Método autoload
 * 
 * Fuunción que carga clases al llamar clases que no se han incluido
 * 
 */
function __autoload($name){
	
	require_once(ROOT."libs".DS.$name.".php");
  
}



?>