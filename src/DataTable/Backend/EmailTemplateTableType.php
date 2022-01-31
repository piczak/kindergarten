<?php

namespace App\DataTable\Backend;

use App\Entity\EmailTemplate;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTable;
use Omines\DataTablesBundle\DataTableTypeInterface;

/**
 * Class EmailTemplateTableType
 * @package App\DataTable\Backend
 */
class EmailTemplateTableType implements DataTableTypeInterface
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
            ->add('description', TextColumn::class, [
                'label' => 'Opis'
            ])
            ->add('rowAction', TwigColumn::class, [
                'label' => '',
                'template' => 'backend/emails/action.column.html.twig',
            ])
            ->createAdapter(ORMAdapter::class, [
                'entity' => EmailTemplate::class,
            ])
        ;
    }
}
