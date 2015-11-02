<?php
/**
 * Clase AppController
 * 
 * Clase controlador padre
 * @author  Cristian Bernal <crisbera@gmail.com>
 */
abstract class AppController
{
	protected $_view;
	protected $db;

	/**
	 * Método __construct
	 * 
	 * Método constructor de la clase inicializa objeto vista y modelo para el manejo de la base de datos
	 * 
	 */
	public function __construct(){
		$this->_view = new View (new Request);
		$this->db = new ClassPDO();
	}


	/**
	 * Método index
	 * 
	 * Método definido por default en el controlador
	* @return  void no regresa ningún valor
	 */
	abstract public function index();

	/**
	 * Método redirect
	 * 
	 * Método que permite redirigir a otras partes de la aplicación 
	 * @param  $url ruta 
	 * @return  void no regresa ningún valor
	 */
	protected function redirect($url = array()){
		$path = "";

		if($url['controller']){
			$path .= $url['controller'];
		}	

		if($url['action']){
			$path .='/'. $url['action'];
		}	

		header("location: ".APP_URL.$path);
	}


}


?>