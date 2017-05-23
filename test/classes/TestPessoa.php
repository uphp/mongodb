<?php
    namespace test\classes;

    use src\Database;

    class TestPessoa extends DataBase{

        private static function ok()
        {
            echo "<span style='color:green'><strong>OK</strong></span>";
        }
        private function error()
        {
            echo "<span style='color:red'><strong>ERROR</strong><br>Class: ".get_called_class()."<br>Nome: ".$this->nome."<br>".$this->_id."</span>";
        }
        
        public function testSave()
        {
            if(get_called_class() == "test\classes\Pessoa" and $this->nome == "Diego Bentes Primeiro" and $this->_id != NULL){
                self::ok();
             }else{
                $this->error();
             }
        }
        public function testUpdate()
        {
            if(get_called_class() == "test\classes\Pessoa" and $this->nome == "Bentes, Diego" and $this->_id != NULL){
                self::ok();
             }else{
                $this->error();
             }
        }
        public function testFindOne()
        {
            if(get_called_class() == "test\classes\Pessoa" and $this->nome == "Diego Bentes" and $this->_id != NULL){
                self::ok();
             }else{
                $this->error();
             }
        }
        public function testFind()
        {
            if(get_called_class() == "test\classes\Pessoa" and $this->nome == "Diego Bentes Último" and $this->_id != NULL){
                self::ok();
             }else{
                $this->error();
             }
        }
        public function testCreate()
        {
            if(get_called_class() == "test\classes\Pessoa" and $this->nome == "Diego Bentes" and $this->_id != NULL){
                self::ok();
             }else{
                $this->error();
             }
        }
        public function testDelete()
        {
            if(get_called_class()::find($this->_id) == FALSE)
            {
                self::ok();
            }else{
                $this->error();
            }
        }
        public function testSoftDelete()
        {
            if($this->deleted_at != NULL){
                self::ok();
            }else{
                $this->error();
            }
        }
        public function testDestroy()
        {
            if(get_called_class()::find($this->_id) == FALSE)
            {
                self::ok();
            }else{
                $this->error();
            }
        }
        public function testSoftDestroy()
        {
            if($this->deleted_at != NULL){
                self::ok();
            }else{
                $this->error();
            }
        }
        public static function testFindAll($object_array)
        {
            if(count($object_array) >= 2){
                foreach($object_array as $obj){
                    if(get_class($obj) == "test\classes\Pessoa"){
                        continue;
                    }else{
                        echo "<span color='red'>ERROR</span>";
                        $not_ok = true;
                        break;
                    }
                }
                if(!isset($not_ok)){
                    self::ok();
                }
            }
        }
        public static function testAll($object_array)
        {
            self::testFindAll($object_array);
        }
        public static function testFirst($object)
        {
            if(get_called_class() == "test\classes\Pessoa" and $object->nome == "Diego Bentes Primeiro" and $object->_id != NULL){
                self::ok();
             }else{
                echo "<span color='red'><strong>ERROR</strong><br>Class: ".get_called_class()."<br>Nome: ".$object->nome."<br>".$object->_id."</span>";
             }
        }
        public static function testLast($object)
        {
            if(get_called_class() == "test\classes\Pessoa" and $object->nome == "Diego Bentes Último" and $object->_id != NULL){
                self::ok();
             }else{
                echo "<span color='red'><strong>ERROR</strong><br>Class: ".get_called_class()."<br>Nome: ".$object->nome."<br>".$object->_id."</span>";
             }
        }
    }