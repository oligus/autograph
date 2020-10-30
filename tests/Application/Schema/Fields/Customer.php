<?php declare(strict_types=1);

namespace Autograph\Tests\Application\Schema\Fields;

use Autograph\GraphQL\AppContext;
use Autograph\Helpers\ClassHelper;
use Autograph\Tests\Application\Entities\Customer as CustomerEntity;
use Autograph\Tests\Application\TypeManager;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * Class Customer
 * @package Autograph\Tests\Application\Schema\Fields
 */
class Customer
{
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('Customer'),
            'args' => ['id' => TypeManager::id()],
            'resolve' => function ($value, array $args, AppContext $appContext): ?array {
                if (!empty($value) && array_key_exists('customer', $value)) {
                    $customer = $value['customer'];
                } else {
                    $em = $appContext->getEm();
                    $qb = $em->createQueryBuilder();
                    $qb->select('t')->from(CustomerEntity::class, 't');
                    $qb->where($qb->expr()->eq('t.id', ':id'));
                    $qb->setParameter(':id', $args['id']);

                    $query = $qb->getQuery();
                    $query->setFetchMode(CustomerEntity::class, 'supportRep', ClassMetadata::FETCH_EAGER);

                    $customer = $query->getOneOrNullResult();
                }

                if (!$customer instanceof CustomerEntity) {
                    return null;
                }

                return [
                    'id' => ClassHelper::getPropertyValue($customer, 'id'),
                    'firstName' => ClassHelper::getPropertyValue($customer, 'firstName'),
                    'lastName' => ClassHelper::getPropertyValue($customer, 'lastName'),
                    'company' => ClassHelper::getPropertyValue($customer, 'company'),
                    'address' => ClassHelper::getPropertyValue($customer, 'address'),
                    'city' => ClassHelper::getPropertyValue($customer, 'city'),
                    'state' => ClassHelper::getPropertyValue($customer, 'state'),
                    'country' => ClassHelper::getPropertyValue($customer, 'country'),
                    'postalCode' => ClassHelper::getPropertyValue($customer, 'postalCode'),
                    'phone' => ClassHelper::getPropertyValue($customer, 'phone'),
                    'fax' => ClassHelper::getPropertyValue($customer, 'fax'),
                    'email' => ClassHelper::getPropertyValue($customer, 'email'),
                    'supportRep' => ClassHelper::getPropertyValue($customer, 'supportRep'),
                ];
            }
        ];
    }
}
