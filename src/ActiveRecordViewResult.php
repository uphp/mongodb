<?php
    namespace UPhp\Model;

    use UPhp\Languages\Label;

    class ActiveRecordViewResult{
        private $function;
        private $class;
        private $value;

        public function __construct($class_name, $func, $value){
            $this->function = $func;
            $this->class = $class_name;
            $this->value = $value;
        }
        public function label(){
            $lang = require("config/application.php");
            $lang = $lang["lang"];
            $labels = Label::getLanguage($this->class, $lang);
            return $labels[$this->function];
        }
        public function value(){
            return $this->value;
        }
    }