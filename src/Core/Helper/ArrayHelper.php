<?php

namespace App\Core\Helper;

/**
 * Class ArrayHelper
 * @package App\Core\Helper
 */
class ArrayHelper
{
    /**
     * @param $array
     * @param int $pieces
     * @return array
     */
    public static function arraySplit($array, $pieces = 2)
    {
        if ($pieces < 2) {
            return array($array);
        }

        $newCount = ceil(count($array)/$pieces);
        $a = array_slice($array, 0, $newCount);
        $b = ArrayHelper::arraySplit(array_slice($array, $newCount), $pieces-1);

        return array_merge(array($a),$b);
    }
}
