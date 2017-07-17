<?php
    namespace UPhp\Model;

    use UPhp\Languages\Label;
    /**
     * Classe para responder aos métodos de manipulação de idiomas e valores das propriedades declaradas no model
     * @package UPhp\Model
     * @link api.uphp.io
     * @since 0.0.1
     * @author Diego Bentes <diegopbentes@gmail.com>
     */
    class ActiveRecordViewResult{
        /**
         * @var $function ActiveRecordViewResult nome da função gerada pelo UPhp associada a propriedade declarada no model.
         */
        private $function;
        /**
         * @var $class ActiveRecordViewResult o nome da classe na qual a função está sendo chamada
         */
        private $class;
        /**
         * @var $value ActiveRecordViewResult o valor da propriedade
         */
        private $value;

        /**
         * Recebe os parametros e guarda em variáveis privadas
         * @param $class_name String Class que o objeto chamado pertence
         * @param $func String Função que foi chamada do objeto
         * @param $value mixed Valor da propriedade do objeto
         */
        public function __construct($class_name, $func, $value){
            $this->function = $func;
            $this->class = $class_name;
            $this->value = $value;
        }

        /**
         * Retorna o label utilizado para a função chamado do objeto, esta função é homonima com o nome da propriedade
         * @return String
         */
        public function label(){
            $lang = require("config/application.php");
            $lang = $lang["lang"];
            $labels = Label::get($this->class, $lang, "db");
            return $labels[$this->function];
        }

        /**
         * Retorna o valor contido na propriedade homonima a função.
         * @return mixed
         */
        public function value(){
            return $this->value;
        }
    }