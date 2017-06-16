<?php
    namespace UPhp\Model;

    use Exception;
    use MongoDB\Driver\Manager as MongoManager;
    use MongoDB\Driver\Command as MongoCommand;
    use src\Inflection;

    require_once "traits/ActiveRecordConnection.php";
    require_once "traits/ActiveRecordPersistence.php";
    require_once "traits/ActiveRecordFinderMethods.php";
    require_once "traits/ActiveRecordPrivateMethods.php";

    class ActiveRecord{

        use \src\traits\ActiveRecordConnection;
        use \src\traits\ActiveRecordPrivateMethods;
        use \src\traits\ActiveRecordPersistence;
        use \src\traits\ActiveRecordFinderMethods;

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

        public function __get($name)
        {
            throw new Exception("Property $name cannot be read");
        }

        public function __set($name, $value)
        {
            throw new Exception("Property $name cannot be set");
        }

        public static function executeCommand($commandStr){
            $connectionInfo = require("config/database.php");            
            $connect = new MongoManager('mongodb://'.$connectionInfo["server"].':'.$connectionInfo["port"]) or die(trataerro(__FILE__, __FUNCTION__, "Não foi possível se conectar ao MongoDB."));
            $command = new MongoCommand($commandStr);
            $connect->executeCommand($connectionInfo["dbname"], $command);
        }
    }