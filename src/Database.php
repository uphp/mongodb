<?php
    namespace src;

    use MongoDB\Driver\Manager as MongoManager;
    use MongoDB\Driver\Query as MongoQuery;
    use MongoDB\Driver\BulkWrite as MongoBulkWrite;

    use Inflection as Inflect;

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
        public $forupdate = FALSE;

        public function __construct(){
            $var = require("connection.php");
            $this->connect($var);
        }

        public function __destruct(){
            //if($this->connection != NULL):
            //    $this->connection->close();
            //endif;
        }

        /*public function __toString()
        {
            return get_class($this);
        }*/

        /* RETORNA AS PROPRIEDADES(ATRIBUTOS) DE UMA CLASSE, SE $ALL FOR VERDADEIRO, É INCLUSO AS PROPRIEDADES DA CLASSE PAI */
        private function getClassVars($all = FALSE)
        {
            if($all){
                $retu = array_keys(get_class_vars(get_class($this)));
            }else{
                $obj_array = array_keys(get_class_vars(get_class($this)));
                $database_array = array_keys(get_class_vars(get_class(new Database())));
                $retu = array_diff($obj_array, $database_array);
            }
            return $retu;
        }

        /* CONVERTE UM OBJETO PARA ARRAY */
        private  function objectToArray(){
            $collection_values = [];
            foreach($this->getClassVars() as $field){
                if($this->$field != NULL){
                    $collection_values[$field] = $this->$field;
                }
            }
            return $collection_values;
        }

        /* ADICIONA AO OBJETO INSTANCIADO OS VALORES DO ARRAY RETORNADO */
        private function addArrayToObject($array){
            foreach($array as $key => $value){
                $this->$key = $value;
            }
        }

        //PADRAO NOVO COM RETORNO DE UM OBJETO DO TIPO INSTANCIADO
        private function findOneReturn($filter, $forUpdate = FALSE){
            $query = new MongoQuery($filter);
            $cursor = $this->connection->executeQuery($this->name_db.'.'.$this->collection, $query);
            $this->addArrayToObject((array)$cursor->toArray()[0]);
            $this->forupdate = $forUpdate;
            return $this;
        }

        /*******************************************************/

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

        /* Manipulation functions ************************************************/
        //PADRAO NOVO COM RETORNO DE UM OBJETO DO TIPO INSTANCIADO
        public function save(){
            if($this->forupdate){
                return $this->update();
            }else{
                $bulk = new MongoBulkWrite();
                $objArray = $this->objectToArray();
                $mongo_id = $bulk->insert($objArray);
                $this->connection->executeBulkWrite($this->name_db.'.'.$this->collection, $bulk);
                return $this->findOneReturn(["_id" => $mongo_id], TRUE);
            }
        }

        //PADRAO NOVO COM RETORNO DE UM OBJETO DO TIPO INSTANCIADO
        public function update(){
            $bulk = new MongoBulkWrite();
            $objArray = $this->objectToArray();
            $bulk->update(["_id" => $this->_id], $objArray);
            $this->connection->executeBulkWrite($this->name_db.'.'.$this->collection, $bulk);
            return $this;
        }

        //PADRAO NOVO COM RETORNO DE UM OBJETO DO TIPO INSTANCIADO
        public function delete(){
            $bulk = new MongoBulkWrite();
            $bulk->delete(["_id" => $this->_id]);
            $this->connection->executeBulkWrite($this->name_db.'.'.$this->collection, $bulk);
            return $this;
        }

        //padrao novo -- TODO
        public static function findAll($filter=NULL){
            $query = new MongoQuery($filter == NULL ? [] : $filter);
            
            $instance = new self();

            $classArray = explode("\\",__CLASS__);
            $className = end($classArray);
            $instance->collection != "" ? $collectionName = $instance->collection : $collectionName = Inflect::pluralize($className);

            

            $cursor = $instance->connection->executeQuery($this->name_db.'.'.$collectionName, $query);

            return $cursor->toArray()[0];        
        }
        
        //PADRAO NOVO -- TODO
        public static function findOne($filter){
            $query = new MongoQuery($filter);            
            $classArray = explode("\\",__CLASS__);
            $className = end($classArray);
            $instance = new $className();
            $cursor = $this->connection->executeQuery($instance->name_db.'.'.$instance->collection, $query);
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