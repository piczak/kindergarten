<?php

namespace App\DataTable\Backend;

use App\Entity\Kindergarten;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTable;
use Omines\DataTablesBundle\DataTableTypeInterface;

class KindergartenTableType implements DataTableTypeInterface
{
    /**
     * @param DataTable $dataTable
     * @param array $options
     */
    public function configure(DataTable $dataTable, array $options)
    {
        $dataTable
            ->add('name', TextColumn::class, [
                'label' => 'Nazwa'
            ])
            ->add('city', TextColumn::class, [
                'label' => 'Miejscowość'
            ])
            ->add('rowAction', TwigColumn::class, [
                'label' => '',
                'template' => 'backend/kindergarten/action.column.html.twig',
                'className' => 'action-column'
            ])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Kindergarten::class,
            ])
        ;
    }
}
