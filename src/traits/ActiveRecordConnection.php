<?php
    namespace UPhp\Model\Traits;

    use MongoDB\Driver\Manager as MongoManager;

    /**
     * Métodos para manipular os drivers de conexão com o Banco de Dados
     * @package UPhp\Model\Traits
     * @link api.uphp.io
     * @since 0.0.1
     * @author Diego Bentes <diegopbentes@gmail.com>
     */
    trait ActiveRecordConnection{

        /**
         * @var string Recebe o endereço do banco de dados
         */
        private $server_addr     = "";
        /**
         * @var string Recebe o usuário para conexão ao banco de dados
         */
        private $user_db         = "";
        /**
         * @var string Recebe a senha para conexão ao banco de dados
         */
        private $pass_db         = "";
        /**
         * @var string Recebe o nome do schema ou nome do banco de dados
         */
        private $name_db         = "";
        /**
         * @var string Recebe a porta de conexão com o banco de dados
         */
        private $port            = "";

        /**
         * Gera uma conexão com o banco de dados e armazena no objeto instanciado.
         * @deprecated Este método deixará de se comportar dessa forma passando a armazenar a conexão em variável estática
         */
        public function connectMongo()
        {
            $this->connection = new MongoManager('mongodb://'.$this->server_addr.':'.$this->port) or die(trataerro(__FILE__, __FUNCTION__, "Não foi possível se conectar ao MongoDB."));
        }

        /**
         * Função para tratamento de erro de conexão com o banco.
         * @deprecated Será substituido por uma exeption.
         * @param null $file
         * @param null $func
         * @param null $msgerror
         * @return string
         */
        public function error_database($file=NULL, $func=NULL, $msgerror=NULL)
        {
            if($arquivo == NULL) $file = "Não informado";
            if($rotina == NULL) $func = "Não informada";
            if($msgerro == NULL) $msgerror = "Não informada";
            $resultado = 'Ocorreu um erro com o seguintes detalhes:<br />
                          <strong>Arquivo:</strong> '.$file.'<br />
                          <strong>Rotina:</strong> '.$func.'<br />
                          <strong><Mensagem:</strong> '.$msgerror;
            return $resultado;
        }

        /**
         * @param $db array Recebe o array carregando em config/database.php do projeto
         */
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