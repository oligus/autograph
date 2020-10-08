<?php declare(strict_types=1);

namespace Autograph\Map\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class FieldType
 * @package Autograph\Map\Enums
 *
 * @method static QueryType SINGLE()
 * @method static QueryType LIST()
 * @method static QueryType NONE()
 */
class QueryType extends Enum
{
    public const SINGLE = 'SINGLE';
    public const LIST = 'LIST';
    public const NONE = 'NONE';
}
