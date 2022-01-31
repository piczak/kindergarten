<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * Class UserStatus
 * @package App\Enum
 */
class UserStatus extends Enum
{
    /**
     * Aktywny
     */
    const ACTIVE = 1;

    /**
     * Nieaktywny
     */
    const INACTIVE = 0;
}
