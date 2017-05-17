<?php
    namespace src\traits;

    use MongoDB\Driver\Query as MongoQuery;

    trait ActiveRecordPrivateMethods{

        /* RETORNA AS PROPRIEDADES(ATRIBUTOS) DE UMA CLASSE, SE $ALL FOR VERDADEIRO, É INCLUSO AS PROPRIEDADES DA CLASSE PAI */
        private function getClassVars($all = FALSE){
            if($all){
                $retu = array_keys(get_class_vars(get_class($this)));
            }else{
                $obj_array = array_keys(get_class_vars(get_class($this)));
                $database_array = array_keys(get_class_vars(get_class(new self())));
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
        private function cursorToObject($cursor){
            $object_list = [];
            foreach($cursor->toArray() as $item){
                //$new_obj = new $instance_class();
                $new_obj = self::newInstanceToCallClass();
                foreach($item as $prop_key => $prop_value){
                    $new_obj->$prop_key = $item->$prop_key;
                }
                array_push($object_list, $new_obj);
            }
            return $object_list;
        }
        //RETORNA UMA INSTANCIA DO OBJETO DO TIPO DA CLASSE CHAMADA
        private static function newInstanceToCallClass(){
            $instance_class = get_called_class();
            $instance = new $instance_class();
            return $instance;
        }

    }