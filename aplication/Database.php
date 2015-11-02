<?php
/**
 * Clase ClassPDO
 * 
 * Clase que permite la conexión y las consultas a la base de datos  
 * @author  Cristian Bernal <crisbera@gmail.com>
 */
class ClassPDO{
	
	public $connection;
    private $dsn;
    private $drive;
    private $host;
    private $database;
    private $username;
    private $password;
    public $result;
    public $lastInsertId;
    public $numbersRows;

    /**
     * Método __construct
     * 
     * Método constructor de la clase que inicializa las variables para la conexión a la base de datos
     * 
     */
    public function __construct(
	    	$drive = 'mysql',
	    	$host='localhost',
	    	$database = 'gestion',
	    	$username = 'root',
	    	$password = ''
    )
    {

	    	$this->drive = $drive;
	    	$this->host = $host;
	    	$this->database = $database;
	    	$this->username = $username;
	    	$this->password = $password;
	    	$this->connection();
           
    }

    /**
     * Método connection
     * 
     * Método que realiza la conexión con la base de datos 
     * @return  void no regresa ningún valor
     */
    public function connection(){
    	$this->dsn = $this->drive.':host='.$this->host.';dbname='.$this->database;
    	
    	try{

    		$this->connection = new PDO(
    			$this->dsn,
    			$this->username,
    			$this->password
    		);

    		$this->connection->setAttribute(
    			PDO::ATTR_ERRMODE,
    			PDO::ERRMODE_EXCEPTION
    		);
            

    	}catch(PDOException $e){

    		echo "ERROR: ".$e->getMessage();
    		die();
    	}
    }

    /**
     * Método save
     * 
     * Método que permite insertar insertar
     * @param  $table nombre de la tabla 
     * @param  $data los datos a guardar
     * @return &this->result el resultado de la consulta
     */
    public function save($table, $data = array()){
    	$sql = "SELECT * FROM $table";
		$result = $this->connection->query($sql);

		for ($i=0; $i < $result->columnCount(); $i++) { 
			$meta = $result->getColumnMeta($i);
			$fields[$meta['name']]=null;
		}

		$fieldsToSave="id";
		$valueToSave="NULL";

		foreach ($data as $key => $value) {
			if(array_key_exists($key, $fields)){
				$fieldsToSave .= ", ".$key;
				$valueToSave  .= ", "."\"$value\""; 
			}
			}

		$sql = "INSERT INTO $table ($fieldsToSave)VALUES($valueToSave);";

		$this->result = $this->connection->query($sql);
        return $this->result;

    }

   /**
     * Método find
     * 
     * Método que obtener o listar datos 
     * @param  $table nombre de la tabla 
     * @param  $query all, first, count
     * @param  $options campos, condiciones
     * @return &this->result el resultado de la consulta
     */
    public function find($table = null, $query = null, $options = array()){
        
        $fields = "*";
        $parameters = "";

        if(!empty($options['field']))
        {
            $fields = $options['field'];
        }

        if(!empty($options['conditions']))
        {
            $parameters = ' WHERE ' .$options['conditions'];
        }

        if(!empty($options['group']))
        {
            $parameters = ' GROUP BY ' .$options['group'];
        }

        if(!empty($options['order']))
        {
            $parameters = ' ORDER BY ' .$options['order'];
        }


        if(!empty($options['limit']))
        {
            $parameters = ' LIMIT ' .$options['limit'];
        }

        switch($query){

            case 'all':
                 $sql = "SELECT $fields FROM $table" .$parameters;
                 $this->result = $this->connection->query($sql);
            break; 

            case 'count':
                 $sql = "SELECT COUNT(*) FROM $table".$parameters;
                 $result = $this->connection->query($sql);
                 $this->result =  $result->fetchColumn();
            break;

            case 'first':
                 $sql = "SELECT $fields FROM $table".$parameters;
                 $result = $this->connection->query($sql);
                 $this->result =  $result->fetch();
            break;

            default:

                 $sql = "SELECT $fields FROM $table".' '.$parameters;
                 $this->result = $this->connection->query($sql);
            break;
        }

        return $this->result;


    }


   /**
     * Método update
     * 
     * Método que actualizar un registro 
     * @param  $table nombre de la tabla 
     * @param  $data los datos de cambio
     * @return &this->result el resultado de la consulta
     */
    public function update($table, $data = array()){
        $sql = "SELECT * FROM $table";
        $result = $this->connection->query($sql);

        for ($i=0; $i < $result->columnCount(); $i++) { 
            $meta = $result->getColumnMeta($i);
            $fields[$meta['name']]=null;
        }

        if(array_key_exists("id",$data)){
            $fieldsToSave = "";
            $id = $data['id'];
            unset($data['id']);

            foreach($data as $key => $value){
                if (array_key_exists($key, $fields)) {
                   $fieldsToSave .= $key."="."\"$value\", "; 
                }
            } 
            $fieldsToSave = substr_replace( $fieldsToSave , "", -2);
            $sql = "UPDATE $table SET $fieldsToSave WHERE $table.id=$id; ";

        }        
        $this->result = $this->connection->query($sql);
        return $this->result;


    }

   /**
     * Método delete
     * 
     * Método para eliminar un registro 
     * @param  $table nombre de la tabla 
     * @param  $condition los datos de cambio
     * @return &this->result el resultado de la consulta
     */
    public function delete($table = null, $condition = null){
        $sql = "DELETE FROM $table WHERE $condition".";";
        
        $this->result = $this->connection->query($sql);

        $this->numberRows = $this->result->rowCount();

        return $this->result;
    }



}


?>