<?php

namespace App\Core\DataTable\ChoiceProvider;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class AdminsChoiceProvider
 * @package App\Core\DataTable\ChoiceProvider
 */
final class AdminsChoiceProvider
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * ArticleCategoriesChoiceProvider constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getChoices(): array
    {
        $items = $this->entityManager
            ->getRepository(User::class)
            ->getByRole('ROLE_ADMIN')
        ;

        $choices = [];
        foreach ($items as $it) {
            $choices[$it->getId()] = $it->getFirstname() . ' ' . $it->getLastname();
        }

        return $choices;
    }
}
