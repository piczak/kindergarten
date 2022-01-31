<?php

namespace App\DataTable\Backend;

use App\Entity\Link;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTable;
use Omines\DataTablesBundle\DataTableTypeInterface;

class LinkTableType implements DataTableTypeInterface
{
    /**
     * @param DataTable $dataTable
     * @param array $options
     */
    public function configure(DataTable $dataTable, array $options)
    {
        $dataTable
            ->add('kindergarten', TextColumn::class, [
                'label' => 'Nazwa',
                'propertyPath' => 'kindergarten.name'
            ])
            ->add('startAt', DateTimeColumn::class, [
                'label' => 'Data od',
                'format' => 'd.m.Y'
            ])
            ->add('endAt', DateTimeColumn::class, [
                'label' => 'Data do',
                'format' => 'd.m.Y'
            ])
            ->add('linkAction', TwigColumn::class, [
                'label' => 'Link',
                'template' => 'backend/links/link.column.html.twig',
                'className' => 'action-column'
            ])
            ->add('rowAction', TwigColumn::class, [
                'label' => '',
                'template' => 'backend/links/action.column.html.twig',
                'className' => 'action-column'
            ])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Link::class,
            ])
        ;
    }
}
