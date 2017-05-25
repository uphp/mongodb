<?php
    namespace test;
    require("../vendor/autoload.php");
    require("classes/TestPessoa.php");
    require("classes/Pessoa.php");
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
            <li role="presentation" class="active"><a href="http://uphp.io">UPhp</a></li>
            <li role="presentation"><a href="http://uphp.io/docs/mongodb">Docs</a></li>
            <li role="presentation"><a href="http://uphp.io/contacts">Contact</a></li>
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
                    <?php include("methodTests/saveForCreate.php"); ?>
                </tr>
                <tr>
                    <?php include("methodTests/saveForUpdate.php"); ?>
                </tr>
                <tr>
                    <?php include("methodTests/create.php"); ?>
                </tr>
                <tr>
                    <?php include("methodTests/update.php"); ?>
                </tr>
                <tr>
                    <?php include("methodTests/findOne.php"); ?>
                </tr>
                <tr>
                    <?php include("methodTests/find.php"); ?>
                </tr>
                <tr>
                    <?php include("methodTests/findAll.php"); ?>
                </tr>
                <tr>
                    <?php include("methodTests/all.php"); ?>
                </tr>
                <tr>
                    <?php include("methodTests/first.php"); ?>
                </tr>
                <tr>
                    <?php include("methodTests/last.php"); ?>
                </tr>
                <tr>
                    <?php include("methodTests/delete.php"); ?>
                </tr>
                <tr>
                    <?php include("methodTests/softDelete.php"); ?>
                </tr>
                <tr>
                    <?php include("methodTests/destroy.php"); ?>
                </tr>
                <tr>
                    <?php include("methodTests/softDestroy.php"); ?>
                </tr>
                <tr>
                    <?php include("methodTests/deleteAll.php"); ?>
                </tr>
                <tr>
                    <?php include("methodTests/destroyAll.php"); ?>
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