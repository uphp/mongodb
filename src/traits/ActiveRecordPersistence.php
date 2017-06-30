<?php
    namespace UPhp\Model\Traits;

    use models\Condominio;

    //use MongoDB\Driver\Query as MongoQuery;
    use MongoDB\Driver\BulkWrite as MongoBulkWrite;
    //use MongoDB\Driver\Manager as MongoManager;
    use MongoDB\BSON\ObjectId as MongoId;
    use src\Inflection as Inflection;
    use UPhp\ActiveRecordValidation\Validate;

    /**
     * Trait para manipulação dos dados do banco
     * @package UPhp\Model\Traits
     * @link api.uphp.io
     * @since 0.0.1
     * @author Diego Bentes <diegopbentes@gmail.com>
     */
    trait ActiveRecordPersistence{

        /**
         * @var bool Variável de controle que habilita o objeto para edição
         */
        private $forupdate  = FALSE;
        /**
         * @var null Recebe o nome da coleção na qual o objeto trabalha
         */
        private $collection = NULL;
        /**
         * @var null Recebe o drive de conexão com o banco
         * @deprecated
         */
        private $connection = NULL;
        /**
         * @var string Recebe o nome da propriedade que será definida como chave primária
         */
        private $pk_field   = "_id";
        /**
         * @var null Guarda o momento exato que o objeto foi persistido no banco
         */
        protected $created_at = NULL;
        /**
         * @var null Guarda o momento exato que o objeto foi atualizado no banco
         */
        protected $updated_at = NULL;
        /**
         * @var null Guarda o momento exato que o objeto foi deletado do banco
         */
        protected $deleted_at = NULL;

        /**
         * O método save() persiste os dados do objeto na coleção setada, caso a propriedade $forupdate seja true, ao invés de salvar um novo objeto, será atualizado.
         * Retorna o objeto criado ou atualizado.
         */
        public function save()
        {
            if (Validate::required(models/Condominio::validate["required"])) {
                if ($this->forupdate) {
                    return $this->update();
                } else {
                    $bulk = new MongoBulkWrite();
                    $this->addTimeStamps();
                    $objArray = $this->objectToArray();
                    $mongo_id = $bulk->insert($objArray);
                    $this->connection->executeBulkWrite($this->name_db . '.' . $this->collection, $bulk);
                    return $this->findOneReturn([$this->pk_field => $mongo_id], TRUE);
                }
            } else {
                throw new \Exception("Campos em branco");
            }
        }

        /**
         * Atualiza um documento no banco a partir de um objeto.
         * Retorna o objeto atualizado.
         */
        public function update()
        {
            $bulk = new MongoBulkWrite();
            $this->updateTimeStamps();
            $objArray = $this->objectToArray();
            $bulk->update([$this->pk_field => $this->_id], $objArray);
            $this->connection->executeBulkWrite($this->name_db.'.'.$this->collection, $bulk);
            return $this;
        }

        /**
         * Exclui um documento do banco de dados.
         * Retorna o objeto deletado.
         */
        public function delete()
        {
            $bulk = new MongoBulkWrite();
            $bulk->delete([$this->pk_field => $this->_id]);
            $this->connection->executeBulkWrite($this->name_db.'.'.$this->collection, $bulk);
            return $this;
        }

        /**
         * Este método se comporta diferente do delete().
         * Ao usar softDelete() o objeto recebe na propriedade deleted_at o momento exato da exclusão, porém ele não é removido do banco de dados
         * Retorna o objeto deletado.
         */
        public function softDelete()
        {
            $this->addTimeStampsDelete();
            return $this->update();
        }

        /**
         * Este método converte o objeto do tipo BSON em string.
         * Retorna uma string com o ID do documento.
         */
        public function getMongoId()
        {
            return (string) new MongoId($this->_id); 
        }

        /**
         * Este método é um alias ao método delete(), porém é estático e necessita que seja passado um parametro.
         * @param $id string Recebe um id do documento que deverá ser deletado do banco.
         */
        public static function destroy($id)
        {
            $object = get_called_class()::findOne(["_id" => $id]);
            return $object->delete();
        }

        /**
         * Funciona como o softDelete(), este método apenas faz com que o objeto receba na propriedade deleted_at o momento exato da exclusão, porém ele não é removido do banco de dados.
         * Retorna o objeto deletado.
         * @param $id string Recebe um id do documento que deverá ser deletado do banco.
         */
        public static function softDestroy($id)
        {
            $object = get_called_class()::findOne(["_id" => $id]);
            $object->addTimeStampsDelete();
            return $object->update();
        }

        /**
         * Exclui todos os documentos da coleção
         */
        public static function deleteAll()
        {
            $arrClassName = explode("\\", get_called_class());
            $className = end($arrClassName);
            self::executeCommand(["drop" => Inflection::pluralize($className)]);

        }

        /**
         * Alias do método deleteAll().
         * Exclui todos os documentos da coleção
         */
        public static function destroyAll()
        {
            self::deleteAll();
        }

        /**
         * Crete persiste na coleção um novo documento sem a necessidade de instanciar antes, recebe apenas o array como parametro.
         * @param array $object_array Array contendo chave e valor homonimo aos atributos da classe
         */
        public static function create(Array $object_array)
        {
            $instance = self::newInstanceToCallClass();
            $instance->addArrayToObject($object_array);
            return $instance->save();
        }

        /**
         * updateAttributes persiste na coleção um novo documento sem a necessidade de instanciar antes, recebe apenas o array como parâmetro.
         * @param array $object_array Array contendo chave e valor homonimo aos atributos da classe
         */
        public function updateAttributes(Array $object_array)
        {
            unset($object_array["_id"]);
            $this->addArrayToObject($object_array);
            $this->forupdate = true;
            return $this->save();
        }
    }