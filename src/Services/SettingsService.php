<?php

namespace App\Services;

use App\Entity\Setting;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Contracts\Cache\ItemInterface;

/**
 * Class SettingsService
 * @package App\Services
 */
class SettingsService
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * @var ArrayHelperService
     */
    protected $arrayHelperService;

    /**
     * @var AdapterInterface
     */
    protected $cache;

    /**
     * SettingsService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ArrayHelperService $arrayHelperService
     * @param AdapterInterface $filesystemAdapter
     */
    public function __construct(EntityManagerInterface $entityManager, ArrayHelperService $arrayHelperService, AdapterInterface $filesystemAdapter)
    {
        $this->entityManager = $entityManager;

        $this->arrayHelperService = $arrayHelperService;

        $this->cache = $filesystemAdapter;
    }

    /**
     * Generowanie drzewka ustawień
     *
     * @return array
     */
    public function getTree()
    {
        $items = $this->entityManager->getRepository(Setting::class)->findBy([
            'type' => 'section'
        ]);

        $settings = [];
        foreach ($items as $it) {
            $settings[$it->getId()] = [
                'id' => $it->getId(),
                'parent' => $it->getParentId() ?: null,
                'name' => $it->getName()
            ];
        }

        return $this->arrayHelperService->nestedArray($settings);
    }

    /**
     * Aktualizacja ustawień
     * @param $request
     */
    public function updateSettings($request)
    {
        foreach ($request as $key => $value) {
            $item = $this->entityManager
                ->getRepository(Setting::class)
                ->findOneBy([
                    'hash' => str_replace('_', '.', $key)
                ]);

            if ($item) {
                $item->setValue($value);

                $this->entityManager->persist($item);
            }
        }

        $this->entityManager->flush();
    }

    /**
     * @param string $hash
     * @return mixed
     */
    public function getSetting(string $hash)
    {
        $value = $this->cache->get($hash . '.settings', function(ItemInterface $cache) use ($hash) {
            $cache->expiresAfter(10);

            $item = $this->entityManager
                ->getRepository(Setting::class)
                ->findOneBy([
                    'hash' => $hash
                ]);

            if ($item) {
                return $item->getValue();
            }

            return null;
        });

        return $value;
    }
}
