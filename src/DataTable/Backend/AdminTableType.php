<?php

namespace App\DataTable\Backend;

use App\Entity\User;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTable;
use Omines\DataTablesBundle\DataTableTypeInterface;

/**
 * Class AdminsTableType
 * @package App\DataTable\Backend
 */
class AdminTableType implements DataTableTypeInterface
{
    /**
     * @param DataTable $dataTable
     * @param array $options
     */
    public function configure(DataTable $dataTable, array $options)
    {
        $dataTable
            ->add('username', TextColumn::class, [
                'label' => 'Login'
            ])
            ->add('email', TextColumn::class, [
                'label' => 'E-mail'
            ])
            ->add('firstname', TextColumn::class, [
                'label' => 'Imię'
            ])
            ->add('lastname', TextColumn::class, [
                'label' => 'Nazwisko'
            ])
            ->add('lastLogin', DateTimeColumn::class, [
                'label' => 'Ostatnie logowanie',
                'format' => 'd.m.Y H:i:s'
            ])
            ->add('rowAction', TwigColumn::class, [
                'label' => '',
                'template' => 'backend/admins/action.column.html.twig',
                'className' => 'action-column'
            ])
            ->createAdapter(ORMAdapter::class, [
                'entity' => User::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('o')
                        ->from(User::class, 'o')
                        ->where('o.roles LIKE :roles')
                        ->orWhere('o.roles LIKE :editorRole')
                        ->setParameter('roles', '%ROLE_ADMIN%')
                        ->setParameter('editorRole', '%ROLE_EDITOR%')
                    ;
                },
            ])
        ;
    }
}
