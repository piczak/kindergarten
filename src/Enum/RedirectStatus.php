<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * Class RedirectStatus
 * @package App\Enum
 */
class RedirectStatus extends Enum
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
