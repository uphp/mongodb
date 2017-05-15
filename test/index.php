<?php
    namespace test;
    require("../vendor/autoload.php");
    use src\Database;
    use Inflection as Inflect;
    
    class Pessoa extends Database{
        public $_id;
        public $nome;

        public static function teste(){
            $className = explode("\\",__CLASS__);
            echo end($className);
        }
    }

    /*$db = array(
		//"server" => "172.25.1.12",
        "server" => "127.0.0.1",
		"port" => "27017",
		"user" => "root",
		"password" => "",
		"dbname" => "local"		
	);*/

    $pessoa = new Pessoa();
    //$pessoa->connect($db);
    $pessoa->collection = "teste_diego";
    //$pessoa->_id = 23010220;
    $pessoa->nome = "Diego Bentes";

    //Pessoa::teste();
    
    $obj_pessoa = $pessoa->save();
    //var_dump($obj_pessoa);

    $obj_pessoa->nome = "Lennon Viadao";
    $update = $obj_pessoa->save();
    //var_dump($update);

    //$delete = $obj_pessoa->delete();
    //var_dump($delete);
    //echo $obj_pessoa->delete();
    //echo $obj_pessoa->objectToArray();

    $pessoas = Pessoa::findAll();
    var_dump($pessoas);

    
    
?>