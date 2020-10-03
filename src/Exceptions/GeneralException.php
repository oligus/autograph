<?php declare(strict_types=1);

namespace Autograph\Exceptions;

use GraphQL\Error\ClientAware;

/**
 * Class GeneralException
 * @package Autograph\Exceptions
 */
class GeneralException extends \Exception implements ClientAware
{
    public function isClientSafe(): bool
    {
        return true;
    }

    public function getCategory(): string
    {
        return 'internal';
    }
}
