<?php
    namespace test;
    require("../vendor/autoload.php");

    use src\Database;

    $db = array(
		"server" => "172.25.1.12",
		"port" => "27017",
		"user" => "root",
		"password" => "",
		"dbname" => "local"		
	);

    $mongo = new Database();    
    $mongo->connect($db);
    
    //$mongo->collection = "enderecos";
    //$one = $mongo->findOne(["nome_logradouro" => "Sacramento Blacke"]);
    //$one = $mongo->findAll(["_id" => 23010220]);
    
    //$mongo->collection = "teste_diego";
    //$one = $mongo->insert(["_id" => 23010220]);
    
    var_dump($one);
    