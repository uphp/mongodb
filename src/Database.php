<?php
    namespace src;

    use MongoDB\Driver\Manager as MongoManager;
    use MongoDB\Driver\Query as MongoQuery;
    use MongoDB\Driver\BulkWrite as MongoBulkWrite;

    class Database{

        public $server_addr     = "";
        public $user_db         = "";
        public $pass_db         = "";
        public $name_db         = "";
        public $port            = "";
        public $connection      = NULL;
        public $database        = NULL;
        public $dataset         = NULL;
        public $affectedrows    = -1;
        /*CRUD.php*/
        public $collection = "";
        public $valuefields = array();
        public $pkfield = NULL;
        public $pkvalue = NULL;
        public $extra_options = "";

        public function __construct(/*$db*/){
        	/*$this->server_addr  = $db["server"];
        	$this->user_db 	    = $db["user"];
        	$this->pass_db 	    = $db["password"];
        	$this->name_db      = $db["dbname"];
            $this->port         = $db["port"];
            $this->connectMongo();*/
        }

        public function __destruct(){
            //if($this->connection != NULL):
                //$this->connection->close();
            //endif;
        }

        public function connectMongo(){
            $this->connection = new MongoManager('mongodb://'.$this->server_addr.':'.$this->port) or die(trataerro(__FILE__, __FUNCTION__, "Não foi possível se conectar ao MongoDB."));
            //$this->database = $this->connection->selectDB($this->name_db) or die(error_database(__FILE__, __FUNCTION__, "Não foi possível se conectar ao Banco de Dados selecionado."));
        }

        public function error_database($file=NULL, $func=NULL, $msgerror=NULL){
            if($arquivo == NULL) $file = "Não informado";
            if($rotina == NULL) $func = "Não informada";
            if($msgerro == NULL) $msgerror = "Não informada";
            $resultado = 'Ocorreu um erro com o seguintes detalhes:<br />
                          <strong>Arquivo:</strong> '.$file.'<br />
                          <strong>Rotina:</strong> '.$func.'<br />
                          <strong><Mensagem:</strong> '.$msgerror;
        }

        /* Manipulation functions */
        //padrao novo
        public function insert($object){
            $bulk = new MongoBulkWrite();
            $bulk->insert($object);
            $this->connection->executeBulkWrite($this->name_db.'.'.$this->collection, $bulk);
        }
        public function update($object, $query){
            $this->database->selectCollection($this->collection)->update($query, $object);
        }
        public function delete($object){
            $this->database->selectCollection($this->collection)->remove($objeto);
        }
        //padrao novo
        public function findAll($filter=NULL){
            $query = new MongoQuery($filter == NULL ? [] : $filter);
            $cursor = $this->connection->executeQuery($this->name_db.'.'.$this->collection, $query);
            return $cursor->toArray();        
        }
        //padrao novo
        public function findOne($filter){
            $query = new MongoQuery($filter);
            $cursor = $this->connection->executeQuery($this->name_db.'.'.$this->collection, $query);
            return $cursor->toArray()[0];
        }
        public function getMongoID($id){
            $mongoId = new MongoId($id);
            return $mongoId;
        }
        public function distinct($object){
            $registros = $this->database->selectCollection($this->collection)->distinct($object);
            return $registros;
        }

        /*CRUD.php*/
        public function addCampo($field=NULL, $value=NULL){
            if($field != NULL):
                $this->valuefields[$field] = $value;
            endif;
        }

        public function delCampo($field){
            if(array_key_exists($field, $this->valuefields)):
                unset($this->valuefields[$field]);
            endif;
        }

        public function setValor($field=NULL, $valor=NULL){
            if($field != NULL && $valor != NULL):
                $this->valuefields[$field] = $valor;
            endif;
        }

        public function getValor($field=NULL){
            if($field != NULL && array_key_exists($field, $this->valuefields)):
                return $this->valuefields[$field];
            else:
                return FALSE;
            endif;
        }

        public function connect($db){
            $this->server_addr  = $db["server"];
        	$this->user_db 	    = $db["user"];
        	$this->pass_db 	    = $db["password"];
        	$this->name_db      = $db["dbname"];
            $this->port         = $db["port"];
            $this->campopk      = "_id";
            $this->connectMongo();
        }

    }