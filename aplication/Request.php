<?php
/**
 * Clase Request
 * Clase que permite la obtener controlador, metodo y argumentos de una url  
 * @author  Cristian Bernal <crisbera@gmail.com>
 */
class Request
{

	private $_controlador;
    private $_metodo;
    private $_argumentos;

  
	/**
	 * Método __construct
	 * 
	 * Método constructor de la clase que valida la url, extrae el controlador, método y argumentos 
	 * 
	 */
   	public function __construct(){
		if(isset($_GET['url'])){
			$url = filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL);
			$url = explode('/',$url);
			$url = array_filter($url);

			$this->_controlador = strtolower(array_shift($url));
			$this->_metodo = strtolower(array_shift($url));
			$this->_argumentos = $url;
		}

		if(!$this->_controlador){	
			$this->_controlador = DEFAULT_CONTROLLER;
		}

		if(!$this->_metodo){	
			$this->_metodo = 'index';
		}

		if(!$this->_argumentos){	
			$this->_argumentos = array();
		}



   	}

    /**
	 * Método getControlador
	 * 
	 * Método que obtiene el controlador 
	 * @return  regresa el nombre del controlador
	 */
   	public function getControlador(){
   		return $this->_controlador;
   	}

   	/**
	 * Método getMetodo
	 * 
	 * Método que obtiene el método del controlador 
	 * @return  regresa el nombre del método
	 */
   	public function getMetodo(){
   		return $this->_metodo;
   	}

    /**
	 * Método getArgs
	 * 
	 * Método que obtiene los argumentos del método
	 * @return  regresa los argumentos
	 */
 	public function getArgs(){
 		return $this->_argumentos;

   	}

}



?>