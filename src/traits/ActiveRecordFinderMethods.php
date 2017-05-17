<?php
    namespace src\traits;

    use MongoDB\Driver\Query as MongoQuery;

    trait ActiveRecordFinderMethods{
        
        //PADRAO NOVO COM RETORNO DE VÁRIOS OBJETOS DO TIPO INSTANCIADO
        public static function all(){
            return self::findAll();
        }
        //PADRAO NOVO COM RETORNO DE UM OBJETO DO TIPO INSTANCIADO BUSCANDO PELO ID
        public static function find($id){
            return self::findOne(["_id" => $id]);
        }
        //PADRAO NOVO COM RETORNO DE VÁRIOS OBJETOS DO TIPO INSTANCIADO
        public static function findAll($filter=NULL){
            $query = new MongoQuery($filter == NULL ? [] : $filter);            
            $instance = self::newInstanceToCallClass();
            $cursor = $instance->connection->executeQuery($instance->name_db.'.'.$instance->collection, $query);
            return $instance->cursorToObject($cursor);
        }
        //PADRAO NOVO COM RETORNO DE UM OBJETO DO TIPO INSTANCIADO
        public static function findOne($filter){
            $query = new MongoQuery($filter);            
            $instance = self::newInstanceToCallClass();
            $cursor = $instance->connection->executeQuery($instance->name_db.'.'.$instance->collection, $query);
            return $instance->cursorToObject($cursor)[0];
        }
        //RETORNO DO PRIMEIRO REGISTRO DA COLECAO
        public static function first(){
            return self::all()[0];
        }
        //RETORNO DO ULTIMO REGISTRO DA COLECAO
        public static function last(){
            $all_objects = self::all();
            return end($all_objects);
        }
    }