<?php

namespace App\Twig\Extensions;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Class XwebExtension
 * @package App\TwigExtension
 */
class XwebExtension extends AbstractExtension
{
    /**
     * @return array|TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('json_decode', [$this, 'jsonDecode']),
            new TwigFilter('json_encode', [$this, 'jsonEncode']),
        ];
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('json_decode', [$this, 'jsonDecode']),
            new TwigFunction('json_encode', [$this, 'jsonEncode']),
        ];
    }

    /**
     * @param string $string
     * @param bool $assoc
     * @param int $depth
     * @param int $options
     * @return mixed
     */
    public function jsonDecode(string $string, bool $assoc = false, int $depth = 512, int $options = 0)
    {
        return json_decode($string, $assoc, $depth, $options);
    }

    /**
     * @param $string
     * @param int $options
     * @param int $depth
     * @return false|string
     */
    public function jsonEncode($string, int $options = 0, int $depth = 512)
    {
        return json_encode($string, $options, $depth);
    }
}
