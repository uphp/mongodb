<?php
    namespace src\traits;

    use MongoDB\Driver\Query as MongoQuery;
    use MongoDB\Driver\BulkWrite as MongoBulkWrite;
    //use src\Inflection as Inflection;

    trait ActiveRecordPersistence{

        private $forupdate = FALSE;
        private $collection = NULL;
        private $connection = NULL;

        /* BEGIN Manipulation Functions ************************************************/
        //PADRAO NOVO COM RETORNO DE UM OBJETO DO TIPO INSTANCIADO
        public function save()
        {
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
        public function update()
        {
            $bulk = new MongoBulkWrite();
            $objArray = $this->objectToArray();
            $bulk->update(["_id" => $this->_id], $objArray);
            $this->connection->executeBulkWrite($this->name_db.'.'.$this->collection, $bulk);
            return $this;
        }
        //PADRAO NOVO COM RETORNO DE UM OBJETO DO TIPO INSTANCIADO
        public function delete()
        {
            $bulk = new MongoBulkWrite();
            $bulk->delete(["_id" => $this->_id]);
            $this->connection->executeBulkWrite($this->name_db.'.'.$this->collection, $bulk);
            return $this;
        }
        public static function create(Array $object_array)
        {
            $instance = self::newInstanceToCallClass();
            $instance->addArrayToObject($object_array);
            return $instance->save();
        }
        /* END Manipulation Functions **************************************************/

    }