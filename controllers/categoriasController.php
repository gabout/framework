<?php
/**
 * Clase categoriasController
 * 
 * Clase para la gestion categorias
 * @author  Cristian Bernal <crisbera@gmail.com>
 */
class categoriasController extends AppController{

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
		
		$this->_view->titulo = "Listado de categorias";
		$this->_view->categorias = $this->db->find('categorias', 'all');
		$this->_view->renderizar('index');
	}

    /**
	 * Método edit
	 * 
	 * Método que edita una categoria
	 * @param  $id la clave de la categoria 
	 * @return  void no regresa ningún valor
	 */
	public function edit($id = NULL){
		if ($_POST){
				if($this->db->update('categorias', $_POST)){
				   $this->redirect(
						  array('controller'=>'categorias','action'=>'index'
							)
						);
			}else{
				$this->redirect(
						  array(
								'controller'=>'categorias',
								'action'=>'edit/'.$_POST['id']
							   )
						  );
					}

		}else{

				$conditions = array(
						  'conditions'=>'id='.$id);
				$this->_view->categoria=$this->db->find(
					'categorias',
					'first',
					$conditions
				);

				$this->_view->titulo="Editar categoria";
				$this->_view->renderizar('edit');

		}
	}

    /**
	 * Método add
	 * 
	 * Método que agrega una categoria
	 * @param  $data los datos de la categoria 
	 * @return  void no regresa ningún valor
	 */
	public function add($data = array()){

		if ($_POST){

			if($this->db->save('categorias',$_POST)){

	           $this->redirect(array('controller'=>'categorias','action'=>'index'));

       		}else{

       			$this->redirect(array('controller'=>'categorias','action'=>'add'));

		    }

		}else{

			$this->_view->titulo="Agregar categoria";
			$this->_view->renderizar=("add");

		}

		$this->_view->renderizar('add');

	}

    /**
	 * Método delete
	 * 
	 * Método que elimina una categoria
	 * @param  $id la clave de la categoria 
	 * @return  void no regresa ningún valor
	 */
	public function delete($id){
		$condition='id='.$id;
		if ($this->db->delete('categorias', $condition)){
			$this->redirect(array('controller'=>'categorias'));
		}
    }




}



?>