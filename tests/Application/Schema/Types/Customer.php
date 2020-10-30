<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Types;

use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ObjectType;
use Autograph\Tests\Application\Schema\Fields;

/**
 * Class Customer
 * @package Autograph\Tests\Application\Schema\Types
 */
class Customer extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Customer',
            'fields' => function (): array {
                return [
                    'id' => TypeManager::id(),
                    'firstName' => TypeManager::string(),
                    'lastName' => TypeManager::string(),
                    'company' => TypeManager::string(),
                    'address' => TypeManager::string(),
                    'city' => TypeManager::string(),
                    'state' => TypeManager::string(),
                    'country' => TypeManager::string(),
                    'postalCode' => TypeManager::string(),
                    'phone' => TypeManager::string(),
                    'fax' => TypeManager::string(),
                    'email' => TypeManager::string(),
                    'supportRep' => (new Fields\Employee())->getField()
                ];
            }
        ];

        parent::__construct($config);
    }
}
