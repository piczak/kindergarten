<?php

namespace App\DataTable\Backend;

use App\Entity\Participant;
use App\Entity\Patient;
use App\Entity\School;
use Doctrine\ORM\QueryBuilder;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Omines\DataTablesBundle\Column\DateTimeColumn;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\Column\TwigColumn;
use Omines\DataTablesBundle\DataTable;
use Omines\DataTablesBundle\DataTableTypeInterface;
use Omines\DataTablesBundle\Filter\DateRangeFilter;
use Omines\DataTablesBundle\Filter\TextFilter;

/**
 * Class ParticipantTableType
 * @package App\DataTable\Backend
 */
class ParticipantTableType implements DataTableTypeInterface
{
    /**
     * @param DataTable $dataTable
     * @param array $options
     */
    public function configure(DataTable $dataTable, array $options)
    {
        $kindergartenFilter = new TextFilter([
            'name' => 'kindergarten',
            'label' => 'Przedszkole',
            'field' => 'k.name'
        ]);

        $childFirstnameFilter = new TextFilter([
            'name' => 'childFirstname',
            'label' => 'Imię dziecka',
            'field' => 'o.childFirstname'
        ]);

        $emailFilter = new TextFilter([
            'name' => 'email',
            'label' => 'E-mail',
            'field' => 'o.email'
        ]);


        $birthAtFilter = new DateRangeFilter([
            'name' => 'birthAt',
            'label' => 'Data urodzenia',
            'field' => 'o.birthAt',
            'criteria' => function(QueryBuilder $builder, $search) {
                $dates = json_decode($search, true);

                $from = $dates['from'] ?? null;
                $to = $dates['to'] ?? null;

                $builder->andWhere($builder->expr()->between('o.birthAt', ':from', ':to'))
                    ->setParameters([
                        'from' => $from,
                        'to' => $to
                    ])
                ;
            }
        ]);

        $expireAtFilter = new DateRangeFilter([
            'name' => 'expireAt',
            'label' => 'Data wygaśnięcia',
            'field' => 'o.expireAt',
            'criteria' => function(QueryBuilder $builder, $search) {
                $dates = json_decode($search, true);

                $from = $dates['from'] ?? null;
                $to = $dates['to'] ?? null;

                $builder->andWhere($builder->expr()->between('o.expireAt', ':from', ':to'))
                    ->setParameters([
                        'from' => $from,
                        'to' => $to
                    ])
                ;
            }
        ]);

        $dataTable
            ->add('kindergarten', TextColumn::class, [
                'label' => 'Nazwa',
                'propertyPath' => 'kindergarten.name'
            ])
            ->add('childFirstname', TextColumn::class, [
                'label' => 'Imię dziecka'
            ])
            ->add('email', TextColumn::class, [
                'label' => 'E-mail'
            ])
            ->add('birthAt', DateTimeColumn::class, [
                'label' => 'Data urodzenia',
                'format' => 'Y-m-d'
            ])
            ->add('expireAt', DateTimeColumn::class, [
                'label' => 'Data wygaśnięcia',
                'format' => 'Y-m-d'
            ])
            ->add('createdAt', DateTimeColumn::class, [
                'label' => 'Data utworzenia',
                'format' => 'Y-m-d'
            ])
            ->add('updatedAt', DateTimeColumn::class, [
                'label' => 'Data aktualizacji',
                'format' => 'Y-m-d'
            ])
            ->add('rowAction', TwigColumn::class, [
                'label' => '',
                'template' => 'backend/participants/action.column.html.twig',
                'className' => 'action-column'
            ])
            ->addFilter($kindergartenFilter)
            ->addFilter($childFirstnameFilter)
            ->addFilter($emailFilter)
            ->addFilter($birthAtFilter)
            ->addFilter($expireAtFilter)
            ->createAdapter(ORMAdapter::class, [
                'entity' => Participant::class,
                'query' => function (QueryBuilder $builder) {
                    $builder
                        ->select('o')
                        ->from(Participant::class, 'o')
                        ->leftJoin('o.kindergarten', 'k')
                    ;
                },
            ])
        ;
    }
}
