<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Types;

use Autograph\Tests\Application\TypeManager;
use GraphQL\Type\Definition\ObjectType;
use Autograph\Tests\Application\Schema\Fields;

/**
 * Class Employee
 * @package Autograph\Tests\Application\Schema\Types
 */
class Employee extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Employee',
            'fields' => function (): array {
                return [
                    'id' => TypeManager::id(),
                    'lastName' => TypeManager::string(),
                    'firstName' => TypeManager::string(),
                    'title' => TypeManager::string(),
                    'reportsTo' => (new Fields\Employee())->getField(),
                    'birthDate' => TypeManager::string(),
                    'hireDate' => TypeManager::string(),
                    'address' => TypeManager::string(),
                    'city' => TypeManager::string(),
                    'state' => TypeManager::string(),
                    'country' => TypeManager::string(),
                    'postalCode' => TypeManager::string(),
                    'phone' => TypeManager::string(),
                    'fax' => TypeManager::string(),
                    'email' => TypeManager::string()
                ];
            }
        ];

        parent::__construct($config);
    }
}
