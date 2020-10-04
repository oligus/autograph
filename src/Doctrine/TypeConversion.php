<?php declare(strict_types=1);

namespace Autograph\Doctrine;

use Autograph\GraphQL\TypeManager;
use GraphQL\Type\Definition\Type;

/**
 * Class TypeConversion
 * @package Autograph\Doctrine
 *
 * Field mapping example:
 *
 * $fieldMapping = [
 *      "fieldName" => "id"
 *      "type" => "integer"
 *      "scale" => 0
 *      "length" => null
 *      "unique" => false
 *      "nullable" => true
 *      "precision" => 0
 *      "columnName" => "CategoryID"
 *      "id" => true
 * ]
 */
class TypeConversion
{
    /**
     * @var array{}|array{fieldName:string,type:string,scale:integer,length:?int,unique:bool,nullable:bool,precision:int,columnName:string,id:bool}
     */
    private array $fieldMapping;

    /**
     * @param array{}|array{fieldName:string,type:string,scale:integer,length:?int,unique:bool,nullable:bool,precision:int,columnName:string,id:bool} $fieldMapping
     */
    public function __construct(array $fieldMapping)
    {
        $this->fieldMapping = $fieldMapping;
    }

    public function getType(): Type
    {
        if ($this->isIdentifier()) {
            return TypeManager::get(Type::ID);
        }

        $inType = $this->fieldMapping['type'];

        switch ($inType) {
            case 'text':
            case 'blob':
            case 'string':
                $type = Type::STRING;
                break;

            case 'integer':
                $type = Type::INT;
                break;

            default:
                $type = Type::STRING;
        }

        return TypeManager::get($type);
    }

    public function isIdentifier(): bool
    {
        return $this->fieldMapping['id'] ?? false;
    }
}
