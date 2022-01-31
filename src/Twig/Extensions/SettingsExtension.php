<?php

namespace App\Twig\Extensions;

use App\Services\SettingsService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class SettingsExtension
 * @package App\Twig\Extensions
 */
class SettingsExtension extends AbstractExtension
{
    /**
     * @var SettingsService
     */
    protected $settingsService;

    /**
     * SettingsExtension constructor.
     * @param SettingsService $settingsService
     */
    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * @return array|TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new TwigFunction('settings', [$this, 'getSetting']),
        ];
    }

    /**
     * @param string $hash
     * @return mixed
     */
    public function getSetting(string $hash)
    {
        return $this->settingsService->getSetting($hash);
    }
}
