<?php
    namespace src\traits;

    trait ActiveRecordPersistence{
        
        /* BEGIN Private Functions *************************************************/
        /* RETORNA AS PROPRIEDADES(ATRIBUTOS) DE UMA CLASSE, SE $ALL FOR VERDADEIRO, É INCLUSO AS PROPRIEDADES DA CLASSE PAI */
        private function getClassVars($all = FALSE){
            if($all){
                $retu = array_keys(get_class_vars(get_class($this)));
            }else{
                $obj_array = array_keys(get_class_vars(get_class($this)));
                $database_array = array_keys(get_class_vars(get_class(new Database())));
                $retu = array_diff($obj_array, $database_array);
            }
            return $retu;
        }
        /* CONVERTE UM OBJETO PARA ARRAY */
        private  function objectToArray(){
            $collection_values = [];
            foreach($this->getClassVars() as $field){
                if($this->$field != NULL){
                    $collection_values[$field] = $this->$field;
                }
            }
            return $collection_values;
        }
        /* ADICIONA AO OBJETO INSTANCIADO OS VALORES DO ARRAY RETORNADO */
        private function addArrayToObject($array){
            foreach($array as $key => $value){
                $this->$key = $value;
            }
        }
        //PADRAO NOVO COM RETORNO DE UM OBJETO DO TIPO INSTANCIADO
        private function findOneReturn($filter, $forUpdate = FALSE){
            $query = new MongoQuery($filter);
            $cursor = $this->connection->executeQuery($this->name_db.'.'.$this->collection, $query);
            $this->addArrayToObject((array)$cursor->toArray()[0]);
            $this->forupdate = $forUpdate;
            return $this;
        }
        //TRANSFORMA UM CURSOR DO MONGO EM UM OBJETO DO TIPO INSTANCIADO
        private function cursorToObject($cursor, $instance_class){
            $object_list = [];
            foreach($cursor->toArray() as $item){
                $new_obj = new $instance_class();
                foreach($item as $prop_key => $prop_value){
                    $new_obj->$prop_key = $item->$prop_key;
                }
                array_push($object_list, $new_obj);
            }
            return $object_list;
        }
        /* END Private Functions ***************************************************/

        /* BEGIN Manipulation Functions ************************************************/
        //PADRAO NOVO COM RETORNO DE UM OBJETO DO TIPO INSTANCIADO
        public function save(){
            if($this->forupdate){
                return $this->update();
            }else{
                $bulk = new MongoBulkWrite();
                $objArray = $this->objectToArray();
                $mongo_id = $bulk->insert($objArray);
                $this->connection->executeBulkWrite($this->name_db.'.'.$this->collection, $bulk);
                return $this->findOneReturn(["_id" => $mongo_id], TRUE);
            }
        }
        //PADRAO NOVO COM RETORNO DE UM OBJETO DO TIPO INSTANCIADO
        public function update(){
            $bulk = new MongoBulkWrite();
            $objArray = $this->objectToArray();
            $bulk->update(["_id" => $this->_id], $objArray);
            $this->connection->executeBulkWrite($this->name_db.'.'.$this->collection, $bulk);
            return $this;
        }
        //PADRAO NOVO COM RETORNO DE UM OBJETO DO TIPO INSTANCIADO
        public function delete(){
            $bulk = new MongoBulkWrite();
            $bulk->delete(["_id" => $this->_id]);
            $this->connection->executeBulkWrite($this->name_db.'.'.$this->collection, $bulk);
            return $this;
        }
        //PADRAO NOVO COM RETORNO DE VÁRIOS OBJETOS DO TIPO INSTANCIADO
        public static function findAll($filter=NULL){
            $query = new MongoQuery($filter == NULL ? [] : $filter);            
            $instance_class = get_called_class();
            $instance = new $instance_class();
            $cursor = $instance->connection->executeQuery($instance->name_db.'.'.$instance->collection, $query);
            return $instance->cursorToObject($cursor, $instance_class);
        }
        //PADRAO NOVO COM RETORNO DE UM OBJETO DO TIPO INSTANCIADO
        public static function findOne($filter){
            $query = new MongoQuery($filter);            
            $instance_class = get_called_class();
            $instance = new $instance_class();
            $cursor = $instance->connection->executeQuery($instance->name_db.'.'.$instance->collection, $query);
            return $instance->cursorToObject($cursor, $instance_class)[0];
        }
        /* END Manipulation Functions **************************************************/

    }