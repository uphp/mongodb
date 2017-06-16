<?php
    namespace src\traits;

    use MongoDB\Driver\Query as MongoQuery;
    use MongoDB\Driver\BulkWrite as MongoBulkWrite;
    use MongoDB\Driver\Manager as MongoManager;
    use MongoDB\BSON\ObjectId as MongoId;
    use src\Inflection as Inflection;

    trait ActiveRecordPersistence{

        private $forupdate  = FALSE;
        private $collection = NULL;
        private $connection = NULL;
        private $pk_field   = "_id";
        protected $created_at = NULL;
        protected $updated_at = NULL;
        protected $deleted_at = NULL;

        /* BEGIN Manipulation Functions ************************************************/
        //PADRAO NOVO COM RETORNO DE UM OBJETO DO TIPO INSTANCIADO
        public function save()
        {
            if($this->forupdate){
                return $this->update();
            }else{
                $bulk = new MongoBulkWrite();
                $this->addTimeStamps();
                $objArray = $this->objectToArray();
                $mongo_id = $bulk->insert($objArray);
                $this->connection->executeBulkWrite($this->name_db.'.'.$this->collection, $bulk);
                return $this->findOneReturn([$this->pk_field => $mongo_id], TRUE);
            }
        }
        //PADRAO NOVO COM RETORNO DE UM OBJETO DO TIPO INSTANCIADO
        public function update()
        {
            $bulk = new MongoBulkWrite();
            $this->updateTimeStamps();
            $objArray = $this->objectToArray();
            //$objectId = new MongoId($this->_id);
            $bulk->update([$this->pk_field => $this->_id], $objArray);
            $this->connection->executeBulkWrite($this->name_db.'.'.$this->collection, $bulk);
            return $this;
        }
        //PADRAO NOVO COM RETORNO DE UM OBJETO DO TIPO INSTANCIADO
        public function delete()
        {
            $bulk = new MongoBulkWrite();
            $bulk->delete([$this->pk_field => $this->_id]);
            $this->connection->executeBulkWrite($this->name_db.'.'.$this->collection, $bulk);
            return $this;
        }        
        public function softDelete()
        {
            $this->addTimeStampsDelete();
            return $this->update();
        }
        public function getMongoId()
        {
            return (string) new MongoId($this->_id); 
        }
        public static function destroy($id)
        {
            $object = get_called_class()::findOne(["_id" => $id]);
            return $object->delete();
        }
        public static function softDestroy($id)
        {
            $object = get_called_class()::findOne(["_id" => $id]);
            $object->addTimeStampsDelete();
            return $object->update();
        }
        public static function deleteAll()
        {
            $arrClassName = explode("\\", get_called_class());
            $className = end($arrClassName);
            self::executeCommand(["drop" => Inflection::pluralize($className)]);

        }
        public static function destroyAll()
        {
            self::deleteAll();
        }
        //CRIA UM NOVO OBJETO
        public static function create(Array $object_array)
        {
            $instance = self::newInstanceToCallClass();
            $instance->addArrayToObject($object_array);
            return $instance->save();
        }
        //ATUALIZA UM OBJETO
        public function update_attributes(Array $object_array)
        {
            unset($object_array["id"]);
            $this->addArrayToObject($object_array);
            $this->forupdate = true;
            return $this->save();
        }
        /* END Manipulation Functions **************************************************/

    }