<?php
    namespace UPhp\Model\Traits;

    use MongoDB\Driver\Query as MongoQuery;
    use MongoDB\BSON\ObjectId as MongoId;

    /**
     * Trait contendo os métodos de busca de dados
     * @package UPhp\Model\Traits
     * @link api.uphp.io
     * @since 0.0.1
     * @author Diego Bentes <diegopbentes@gmail.com>
     */
    trait ActiveRecordFinderMethods{

        /**
         * Método alias para findALL(), porém não recebe parametros, ou seja, não permite filtros como o findAll().
         * Retorna um array de objetos do tipo instanciado.
         */
        public static function all()
        {
            return self::findAll();
        }

        /**
         * Retorna um objeto do tipo instanciado através de busca de ID ou FALSE caso não encontre
         * @param $id string Recebe um id para busca de um documento
         */
        public static function find($id)
        {
            if (is_string($id) && $id != "") {
                $id = new MongoId($id);
            }
            return self::findOne(["_id" => $id]);
        }

        /**
         * Faz uma busca no banco de dados e retorna todos os documentos encontrados
         * @param null $filter Recebe o filtro de busca no banco de dados
         */
        public static function findAll($filter=NULL)
        {
            $query = new MongoQuery($filter == NULL ? [] : $filter);            
            $instance = self::newInstanceToCallClass();
            $cursor = $instance->connection->executeQuery($instance->name_db.'.'.$instance->collection, $query);
            return $instance->cursorToObject($cursor);
        }

        /**
         * Retorna um objeto do tipo instanciado ou FALSE se o não encontrar nada
         * @param $filter
         */
        public static function findOne($filter)
        {
            $query = new MongoQuery($filter);
            $instance = self::newInstanceToCallClass();
            $cursor = $instance->connection->executeQuery($instance->name_db. '.' .$instance->collection, $query);
            $objects = $instance->cursorToObject($cursor);
            if(count($objects) > 0)
            {
                return $objects[0];
            }else{
                return false;
            }
            
        }

        /**
         * Retorna o primeiro objeto da coleção
         */
        public static function first()
        {
            return self::all()[0];
        }

        /**
         * Retorna o último objeto da coleção
         */
        public static function last()
        {
            $all_objects = self::all();
            return end($all_objects);
        }
    }