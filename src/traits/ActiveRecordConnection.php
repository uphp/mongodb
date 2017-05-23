<?php
    namespace src\traits;

    use MongoDB\Driver\Manager as MongoManager;

    trait ActiveRecordConnection{

        private $server_addr     = "";
        private $user_db         = "";
        private $pass_db         = "";
        private $name_db         = "";
        private $port            = "";

        public function connectMongo()
        {
            $this->connection = new MongoManager('mongodb://'.$this->server_addr.':'.$this->port) or die(trataerro(__FILE__, __FUNCTION__, "Não foi possível se conectar ao MongoDB."));
        }

        public function error_database($file=NULL, $func=NULL, $msgerror=NULL)
        {
            if($arquivo == NULL) $file = "Não informado";
            if($rotina == NULL) $func = "Não informada";
            if($msgerro == NULL) $msgerror = "Não informada";
            $resultado = 'Ocorreu um erro com o seguintes detalhes:<br />
                          <strong>Arquivo:</strong> '.$file.'<br />
                          <strong>Rotina:</strong> '.$func.'<br />
                          <strong><Mensagem:</strong> '.$msgerror;
        }

        public function connect($db)
        {
            $this->server_addr  = $db["server"];
        	$this->user_db 	    = $db["user"];
        	$this->pass_db 	    = $db["password"];
        	$this->name_db      = $db["dbname"];
            $this->port         = $db["port"];
            $this->connectMongo();
        }

    }