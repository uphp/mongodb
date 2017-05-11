<?php
    namespace test;
    require("../vendor/autoload.php");
    use src\Database;
    
    class Pessoa extends Database{
        public $_id;
        public $nome;

        public static function teste(){
            $className = explode("\\",__CLASS__);
            echo end($className);
        }
    }

    $db = array(
		"server" => "172.25.1.12",
		"port" => "27017",
		"user" => "root",
		"password" => "",
		"dbname" => "local"		
	);

    $pessoa = new Pessoa();
    $pessoa->connect($db);
    $pessoa->collection = "teste_diego";
    //$pessoa->_id = 23010220;
    $pessoa->nome = "Diego Bentes";

    //Pessoa::teste();
?>
    
    <!-- html>
    <head><title>Roteiro de Teste</title></head>
    <body>
        <table>
            <tr>
                <td>Descrição</td>
                <td>Função</td>
                <td>Resultado</td>
            </tr>
            <tr -->

<?php
    //echo "<td>Criar nova pessoa</td>";
    //echo "<td>save();</td>";

    $obj_pessoa = $pessoa->save();
    var_dump($obj_pessoa);
    echo $obj_pessoa->delete();
    //echo $obj_pessoa->objectToArray();

    
    
?>
            </tr>
        </table>
    </body>
</html>