<?php
    namespace test;
    require("../vendor/autoload.php");
    use src\Database;
    
    class Pessoa extends Database{
        public $_id = NULL;
        public $nome = NULL;

        public function testSave(){
            if(get_called_class() == "test\Pessoa" and $this->nome == "Diego Bentes" and $this->_id != NULL){
                echo "<span color='green'>OK</span>";
             }else{
                echo "<span color='red'><strong>ERROR</strong><br>Class: ".get_called_class()."<br>Nome: ".$this->nome."<br>".$this->_id."</span>";
             }
        }
        public function testUpdate(){
            if(get_called_class() == "test\Pessoa" and $this->nome == "Bentes, Diego" and $this->_id != NULL){
                echo "<span color='green'>OK</span>";
             }else{
                echo "<span color='red'><strong>ERROR</strong><br>Class: ".get_called_class()."<br>Nome: ".$this->nome."<br>".$this->_id."</span>";
             }
        }
        public function testFindOne(){
            $this->testUpdate();
        }
        public function testFind(){
            $this->testUpdate();
        }
        public function testCreate(){
            $this->testFindOne();
        }
        public static function testFindAll($object_array){
            if(count($object_array) >= 2){
                foreach($object_array as $obj){
                    if(get_class($obj) == "test\Pessoa"){
                        continue;
                    }else{
                        echo "<span color='red'>ERROR</span>";
                        $not_ok = true;
                        break;
                    }
                }
                if(!isset($not_ok)){
                    echo "<span color='green'>OK</span>";
                }
            }
        }
        public static function testDelete($object_array){
            if(count($object_array) == 0){
                echo "<span color='green'>OK</span>";
            }else{
                echo "<span color='red'>ERROR</span>";
            }
        }
        public static function testAll($object_array){
            self::testFindAll($object_array);
        }
    }

    //save
    $pessoa = new Pessoa();
    $pessoa->nome = "Diego Bentes";
    $pessoa_save = $pessoa->save();

    //save
    $pessoa_create = Pessoa::create(["nome" => "Bentes, Diego"]);

    //update
    $pessoa = Pessoa::findOne(["_id" => $pessoa->_id]);
    $pessoa->nome = "Bentes, Diego";
    $pessoa_update = $pessoa->update();

    //findOne
    $pessoa_findOne = Pessoa::findOne(["_id" => $pessoa->_id]);

    //find
    $pessoa_find = Pessoa::find($pessoa->_id);

    //findAll
    $pessoa = new Pessoa();
    $pessoa->nome = "Diego Bentes";
    $pessoa_save = $pessoa->save();
    $pessoas = Pessoa::findAll();

    //all
    $pessoas_all = Pessoa::all();

    //first - ADD IN TABLE TEST
    $pessoa_first = Pessoa::first();
    //var_dump($pessoa_first);

    //last - ADD IN TABLE TEST
    $pessoa_last = Pessoa::last();

    //delete
    foreach($pessoas as $pessoa){
        $pessoa->delete();
    }
    $pessoas_delete = Pessoa::findAll();

    
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>Teste MongoDB</title>

    <!-- Bootstrap core CSS -->
    <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="http://getbootstrap.com/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="http://getbootstrap.com/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="http://getbootstrap.com/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills pull-right">
            <li role="presentation" class="active"><a href="#">UPhp</a></li>
            <li role="presentation"><a href="#">Docs</a></li>
            <li role="presentation"><a href="#">Contact</a></li>
          </ul>
        </nav>
        <h3 class="text-muted">Author: Diego Bentes</h3>
      </div>

      <div class="jumbotron">
        <h1>MongoDB Library for UPhp</h1>
        <p class="lead">Esta biblioteca necessita da extensão para PHP php_mondodb.dll se for windows ou mongodb.so para linux.</p>
        <p><a class="btn btn-lg btn-success" href="#" role="button">UPhp</a></p>
      </div>

      <div class="row text-center">
        <div class="col-lg-12">
            <h1>Roteiro de testes para MongoDB</h1><br><br>
        </div>
      </div>

      <div class="row ">
        <div class="col-lg-12">
            <table class="table">
                <tr>
                    <th>Descrição</th>
                    <th>Função</th>
                    <th>Teste</th>
                </tr>
                <tr>
                    <td>Cria um novo documento</td>
                    <td>.save()</td>
                    <td><?php $pessoa_save->testSave() ?></td>
                </tr>
                <tr>
                    <td>Cria um novo documento</td>
                    <td>::create(Array $object_array)</td>
                    <td><?php $pessoa_create->testCreate() ?></td>
                </tr>
                <tr>
                    <td>Atualiza um documento</td>
                    <td>.update()</td>
                    <td><?php $pessoa_update->testUpdate() ?></td>
                </tr>
                <tr>
                    <td>Busca um único documento</td>
                    <td>::findOne(Array $filter)</td>
                    <td><?php $pessoa_findOne->testFindOne() ?></td>
                </tr>
                <tr>
                    <td>Busca um único documento</td>
                    <td>::find($id)</td>
                    <td><?php $pessoa_find->testFind() ?></td>
                </tr>
                <tr>
                    <td>Busca todos os documentos</td>
                    <td>::findAll(Array $filter=[])</td>
                    <td><?php Pessoa::testFindAll($pessoas) ?></td>
                </tr>
                <tr>
                    <td>Busca todos os documentos</td>
                    <td>::all()</td>
                    <td><?php Pessoa::testAll($pessoas_all) ?></td>
                </tr>
                <tr>
                    <td>Busca o primeiro documento</td>
                    <td>::first()</td>
                    <td><?php  ?></td>
                </tr>
                <tr>
                    <td>Busca o último documento</td>
                    <td>::last()</td>
                    <td><?php  ?></td>
                </tr>
                <tr>
                    <td>Exclui um documento</td>
                    <td>.delete()</td>
                    <td><?php Pessoa::testDelete($pessoas_delete) ?></td>
                </tr>
            </table>
        </div>
          
      </div>

      <footer class="footer">
        <p>&copy; 2017 UPhp, Inc.</p>
      </footer>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="http://getbootstrap.com/assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>