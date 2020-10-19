<?php declare(strict_types=1);

namespace Autograph\Map\Enums;

use MyCLabs\Enum\Enum;

/**
 * Class QueryMethod
 * @package Autograph\Map\Enums
 *
 * @method static QueryMethod SINGLE()
 * @method static QueryMethod LIST()
 * @method static QueryMethod NONE()
 */
class QueryMethod extends Enum
{
    public const SINGLE = 'SINGLE';
    public const LIST = 'LIST';
    public const NONE = 'NONE';
}
