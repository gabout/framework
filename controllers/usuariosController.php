<?php
/**
 * Clase usuariosController
 * 
 * Clase para la gestión de usuarios 
 * @author  Cristian Bernal <crisbera@gmail.com>
 */
class usuariosController extends AppController{

	/**
	 * Método __construct
	 * 
	 * Método constructor de la clase 
	 * 
	 */
	public function __construct(){
		parent::__construct();

	}

    /**
	 * Método index
	 * 
	 * Método por default del controlador
	 * @return  void no regresa ningún valor
	 */
	public function index(){
		$this->_view->titulo = "Listado de usuarios";
		$this->_view->usuarios = $this->db->find('usuarios', 'all');
		$this->_view->renderizar('index');
	}

    /**
	 * Método edit
	 * 
	 * Método que edita un usuario
	 * @param  $id la clave del usuario
	 * @return  void no regresa ningún valor
	 */
	public function edit($id = null){

		if ($_POST){
			if (!empty($_POST['pass'])) {
				$pass = new Password();
				$_POST['password'] = $pass->getPassword($_POST['pass']);;
			}
			if ($this->db->update("usuarios", $_POST)) {
				$this->redirect(array('controller'=>'usuarios', 'action'=>'index'));
			}else{
				$this->redirect(array('controller'=>'usuarios', 'action'=>'edit'));
			}
		}else{
			$this->_view->titulo = "Editar usuario";
			$this->_view->usuario = $this->db->find('usuarios', 'first', array('conditions'=>'id='.$id));
			$this->_view->renderizar('edit');
		}	

	
	}

    /**
	 * Método add
	 * 
	 * Método que agrega un usuario
	 * @param  $data los datos del usuario
	 * @return  void no regresa ningún valor
	 */
	public function add(){
		if ($_POST){
			$pass = new Password();

			$_POST['password'] = $pass->getPassword($_POST['password']);

			if ($this->db->save("usuarios", $_POST)) {
				$this->redirect(array('controller'=>'usuarios', 'action'=>'index'));
			}else{
				$this->redirect(array('controller'=>'usuarios', 'action'=>'add'));
			}
		}else{
			$this->_view->titulo = "Agregar usuario";
			$this->_view->renderizar('add');
		}

	}

    /**
	 * Método delete
	 * 
	 * Método que elimina un usuario
	 * @param  $id la clave del usuario 
	 * @return  void no regresa ningún valor
	 */
	public function delete($id = null){

		$conditions = 'id='.$id;
		if ($this->db->delete('usuarios', $conditions)) {
			$this->redirect(
					array(
						'controller'=>'usuarios',
						'action'=>'index'
					)	
			);
		}


	}

    /**
	 * Método login
	 * 
	 * Método que autentifica a los usuarios
	 * @return  void no regresa ningún valor
	 */
	public function login(){
          
		if($_POST){
			$pass = new Password();
			$filter = new Validations();
			$auth = new Authorization();

			$username = $filter->sanitizeText($_POST['username']);
			$password = $filter->sanitizeText($_POST['password']);

			$options = array('conditions' => "username= '$username'");
			$usuario = $this->db->find('usuarios', 'first', $options);
           
			if($pass->isValid($password, $usuario['password'])){
				$auth->login($usuario);				
				$this->redirect(array('controller'=>'tareas'));

			}
			else{
				echo "Usuario no válido";
			}

		}

		$this->_view->renderizar('login');

	}

    /**
	 * Método logout
	 * 
	 * Método que cierra una sesión del usuario
	 * @return  void no regresa ningún valor
	 */
	public function logout(){
		$auth = new Authorization();
		$auth->logout();
	}




}



?>