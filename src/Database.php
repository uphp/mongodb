<?php
    namespace UPhp\Model;

    use Exception;
    use MongoDB\Driver\Manager as MongoManager;
    use MongoDB\Driver\Command as MongoCommand;
    use src\Inflection;
    use UPhp\ActiveRecordValidation\Validate;

    /**
     * Classe de manipulação de dados, aqui estão definidos os métodos mágicos
     * @package UPhp\Model
     * @link api.uphp.io
     * @since 0.0.1
     * @author Diego Bentes <diegopbentes@gmail.com>
     */
    class Database{

        /**
         * Trait para tratamento das conexões com o banco
         */
        use Traits\ActiveRecordConnection;
        /**
         * Trait contendo os métodos privados utilizados pela classe
         */
        use Traits\ActiveRecordPrivateMethods;
        /**
         * Trait contendo os métodos de persistência de dados no banco
         */
        use Traits\ActiveRecordPersistence;
        /**
         * Trait contendo os métodos de busca do banco
         */
        use Traits\ActiveRecordFinderMethods;

        /**
         * Recebe um array com chave e valor que serão convertidos em objeto do tipo chamado passando as propriedades(array_keys) os valores(array_values) do array.
         * @param array $object_array Array contendo chave e valor, sendo a chave com nome correspondente a propriedade do objeto.
         */
        public function __construct(Array $object_array = []) 
        {
            $var = require("config/database.php");
            $this->connect($var);

            $instance_class = get_called_class();
            $classArray = explode("\\",$instance_class);
            $className = end($classArray);
            $this->collection = Inflection::pluralize($className);

            $this->addArrayToObject($object_array);
        }

        /**
         * Não permite pegar o valor de uma propriedade não declarada.
         * @param $name string Recebe o nome da propriedade
         * @throws Exception
         */
        public function __get($name)
        {
            throw new Exception("Property $name cannot be read");
        }

        /**
         * Não permite criar um novo atributo ao objeto caso ele não tenha sido declarado
         * @param $name string Recebe o nome da propriedade
         * @param $value string Recebe o valor da propriedade
         * @throws Exception
         */
        public function __set($name, $value)
        {
            throw new Exception("Property $name cannot be set");
        }

        /**
         * A função __call é utilizada para dinamicamente tratar chamadas de funções inexistentes.
         * Aqui o objetivo é verificar se a função chamada tem ligação com uma coluna ou propriedade no banco de dados
         * No caso do MongoDB, o arquivo db_dump.json é carregado e comparado com a função, caso exista o tratamento segue e entrega a
         * ActiveRecordViewResult o nome da classe, função e valor, permitindo assim criar as chamadas sem erro.
         * @param $func
         * @param $params
         * @return ActiveRecordViewResult
         * @throws Exception
         */
        public function __call($func, $params){
            
            $db_dump = json_decode(file_get_contents("db/db_dump.json"), true);
            $config = require("config/database.php");
            
            $class_name = get_called_class();
            $class_name = explode("\\", $class_name)[1];
            $class_name = Inflection::pluralize($class_name);

            if (in_array($func, $db_dump[$config["dbname"]][$class_name])) {
                return new ActiveRecordViewResult(Inflection::singularize($class_name), $func, $this->$func);
            } else {
                throw new \Exception("PRECISO TRATAR ESSE ERRO AINDA"); 
            }

        }

        /**
         * Executa um comando no mongo sem precisar de uma instância
         * @param $commandStr string Recebe um comando Mongo
         * @deprecated Essa função será removida em breve
         */
        public static function executeCommand($commandStr){
            $connectionInfo = require("config/database.php");            
            $connect = new MongoManager('mongodb://'.$connectionInfo["server"].':'.$connectionInfo["port"]) or die(trataerro(__FILE__, __FUNCTION__, "Não foi possível se conectar ao MongoDB."));
            $command = new MongoCommand($commandStr);
            $connect->executeCommand($connectionInfo["dbname"], $command);
        }
    }