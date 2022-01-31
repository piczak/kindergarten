<?php

namespace App\Enum;

use MyCLabs\Enum\Enum;

/**
 * Class SettingsType
 * @package App\Enum
 */
class SettingsType extends Enum
{
    /**
     * Pole tekstowe
     */
    const TEXT = 'text';

    /**
     * Pole textarea
     */
    const TEXTAREA = 'textarea';

    /**
     * Pole wyboru
     */
    const CHOICE = 'choice';

    /**
     * Pole CKE
     */
    const EDITOR = 'editor';
}
