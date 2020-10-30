<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Fields;

use Autograph\GraphQL\AppContext;
use Autograph\Helpers\ClassHelper;
use Autograph\Tests\Application\TypeManager;
use Autograph\Tests\Application\Entities\Employee as EmployeeEntity;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class Employee
 * @package Autograph\Tests\Application\Schema\Fields
 */
class Employee
{
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('Employee'),
            'args' => ['id' => TypeManager::id()],
            'resolve' => function ($value, array $args, AppContext $appContext): ?array {
                if (!empty($value) && array_key_exists('reportsTo', $value)) {
                    $employee = $value['reportsTo'];
                } elseif (!empty($value) && array_key_exists('employee', $value)) {
                    $employee = $value['employee'];
                } elseif (!empty($value) && array_key_exists('supportRep', $value)) {
                    $employee = $value['supportRep'];
                } else {
                    $em = $appContext->getEm();
                    $qb = $em->createQueryBuilder();
                    $qb->select('t')->from(EmployeeEntity::class, 't');
                    $qb->where($qb->expr()->eq('t.id', ':id'));
                    $qb->setParameter(':id', $args['id']);

                    $query = $qb->getQuery();
                    $query->setFetchMode(EmployeeEntity::class, 'reportsTo', ClassMetadata::FETCH_EAGER);

                    $employee = $query->getOneOrNullResult();
                }

                if (!$employee instanceof EmployeeEntity) {
                    return null;
                }

                return [
                    'id' => ClassHelper::getPropertyValue($employee, 'id'),
                    'lastName' => ClassHelper::getPropertyValue($employee, 'lastName'),
                    'firstName' => ClassHelper::getPropertyValue($employee, 'firstName'),
                    'title' => ClassHelper::getPropertyValue($employee, 'title'),
                    'reportsTo' => ClassHelper::getPropertyValue($employee, 'reportsTo'),
                    'birthDate' => ClassHelper::getPropertyValue($employee, 'birthDate'),
                    'hireDate' => ClassHelper::getPropertyValue($employee, 'hireDate'),
                    'address' => ClassHelper::getPropertyValue($employee, 'address'),
                    'city' => ClassHelper::getPropertyValue($employee, 'city'),
                    'state' => ClassHelper::getPropertyValue($employee, 'state'),
                    'country' => ClassHelper::getPropertyValue($employee, 'country'),
                    'postalCode' => ClassHelper::getPropertyValue($employee, 'postalCode'),
                    'phone' => ClassHelper::getPropertyValue($employee, 'phone'),
                    'fax' => ClassHelper::getPropertyValue($employee, 'fax'),
                    'email' => ClassHelper::getPropertyValue($employee, 'email')
                ];
            }
        ];
    }
}
