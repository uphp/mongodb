<?php
    namespace src;

    use Exception;

    require_once "traits/ActiveRecordConnection.php";
    require_once "traits/ActiveRecordPersistence.php";
    require_once "traits/ActiveRecordFinderMethods.php";
    require_once "traits/ActiveRecordPrivateMethods.php";

    class Database{

        use \src\traits\ActiveRecordConnection;
        use \src\traits\ActiveRecordPrivateMethods;
        use \src\traits\ActiveRecordPersistence;
        use \src\traits\ActiveRecordFinderMethods;                

        public function __construct() 
        {
            $var = require("connection.php");
            $this->connect($var);

            $instance_class = get_called_class();
            $classArray = explode("\\",$instance_class);
            $className = end($classArray);
            $this->collection = Inflection::pluralize($className);
        }

        public function __get($name)
        {
            throw new Exception("Property $name cannot be read");
        }

        public function __set($name, $value)
        {
            throw new Exception("Property $name cannot be set");
        }
    }