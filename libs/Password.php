<?php
/**
* Clase para el manejo de contraseñas
*
* Funciones para la generación de hash de contraseñas
* @author  Cristian Bernal <crisbera@gmail.com>
*/
class Password{
	
	/**
	 * Método __construct
	 * 
	 * Método constructor de la clase que determina si el algoritmo blowfish es soportado
	 * 
	 */
	public function __construct(){
		$this->checkBlowfish();
	}

	/**
	 * Método checkBlowFish
	 * 
	 * Método que sirve para comprobar si el algoritmo blowfish es soportado
	* @return  void no regresa ningún valor
	 */
	private function checkBlowfish(){
		if (!defined("CRYPT_BLOWFISH") && !CRYPT_BLOWFISH) {
			echo "Algoritmo Blowfish no roportado";
			die();
		}
	}


	/**
	 * Método getPassword
	 * 
	 * Método que permite que cifrar la contraseña
	 * @param  $password contraseña a cifrar
	 * @return  hash generado 
	 */
	public function getPassword($password, $dig = 7){
		$set_salt = './1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
		$salt = sprintf('$2a$%02d$', $dig);
		for ($i=0; $i < 22; $i++) { 
			$salt .= $set_salt[mt_rand(0, 22)];
		}

		return crypt($password, $salt);
	}


	/**
	 * Método isValid 
	 * 
	 * Método que valida dos contraseñas
	 * @param  $pass1 contraseña a comparar
	 * @param  $pass2 contraseña 
	 * @return  true o false
	 */
	public function isValid($pass1, $pass2){
		if (crypt($pass1, $pass2) == $pass2) {
			return true;
		}
		
		return false;	
	}

	/**
	 * Método passwordVerify
	 * 
	 * Método que verifica par de contraseñas
	 * @param  $pass1 contraseña 1
	 * @param  $pass2 contraseña 2
	 * @return  true o false
	 */
	public function passwordVerify($pass1, $pass2){
		if (password_verify($pass1, $pass2)) {
			return true;
		}
		return false;
	}
}