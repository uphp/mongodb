<?php
namespace UPhp\Model\Traits;

//use MongoDB\Driver\BulkWrite as MongoBulkWrite;
//use MongoDB\BSON\ObjectId as MongoId;
//use UPhp\ActiveRecordValidation\Validate as Validate;
//use src\Inflection as Inflection;
use UPhp\Languages\Label;


/**
 * Trait para manipulação das validações no UPhp
 * @package UPhp\Model\Traits
 * @link api.uphp.io
 * @since 0.0.1
 * @author Diego Bentes <diegopbentes@gmail.com>
 */
trait ActiveRecordValidation{

    /**
     * Função para verificação das validações
     * @return bool
     */
    protected function isValid(){
        $validated = true;
        if (isset($this->validate)) {
            $validateFunctions = array_keys($this->validate);
            foreach ($validateFunctions as $vFunction) {
                if ($vFunction == "required") {
                    if ($this->required()) {
                        $validated = $validated && true;
                    } else {
                        $validated = $validated && false;
                    }

                } elseif ($vFunction == "uniqueness") {
                    $validated = $validated && FALSE; //TODO
                } else {
                    $validated = $validated && $this->$vFunction();
                }
            }
        }
        return $validated;
    }

    /**
     * Função para verificação de campos em branco.
     * Retorna um boolean com o resultado da validação.
     * @param array $fields Recebe os nomes dos campos aos quais deverão ser validados se estão em branco.
     */
    private function required()
    {
        $validated = true;
        foreach ($this->validate["required"] as $field) {
            if (empty($this->$field)) {

                $validated = $validated && false;
                $className = get_class($this);
                $className = explode("\\", $className)[1];
                $lang = require("config/application.php");
                $lang = $lang["lang"];
                $msg = Label::getValidateLanguage($className, "required", $lang, $field);
                if (empty($msg)) {
                    $msg = $field . " is required";
                }
                $this->errors[] = [$field => $msg];
            } else {
                $validated = $validated && true;
            }
        }
        return $validated;
    }

}