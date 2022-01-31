<?php

namespace App\Services;

/**
 * Class ArrayHelperService
 * @package App\Services
 */
class ArrayHelperService
{
    /**
     * Tworzenie drzewka
     * @param $source
     * @return array
     */
    public function nestedArray($source)
    {
        $nested = array();

        foreach ($source as &$s) {
            if (is_null($s['parent'])) {
                $nested[] = &$s;
            } else {
                $pid = $s['parent'];

                if (isset($source[$pid])) {
                    if (!isset($source[$pid]['children'])) {
                        $source[$pid]['children'] = [];
                    }

                    $source[$pid]['children'][] = &$s;
                }
            }
        }

        return $nested;
    }
}
