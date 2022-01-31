<?php

namespace App\DataTable\Backend;

use App\Entity\Redirect;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTable;
use Omines\DataTablesBundle\DataTableTypeInterface;

/**
 * Class RedirectTableType
 * @package App\DataTable\Backend
 */
class RedirectTableType implements DataTableTypeInterface
{
    /**
     * @param DataTable $dataTable
     * @param array $options
     */
    public function configure(DataTable $dataTable, array $options)
    {
        $dataTable
            ->add('fromLink', TextColumn::class, [
                'label' => 'Adres bazowy'
            ])
            ->add('toLink', TextColumn::class, [
                'label' => 'Adres docelowy'
            ])
            ->add('isActive', TwigColumn::class, [
                'label' => 'Status',
                'template' => 'backend/redirects/status.column.html.twig',
                'className' => 'status-column'
            ])
            ->add('rowAction', TwigColumn::class, [
                'label' => '',
                'template' => 'backend/redirects/action.column.html.twig',
                'className' => 'action-column'
            ])
            ->createAdapter(ORMAdapter::class, [
                'entity' => Redirect::class,
            ])
        ;
    }
}
