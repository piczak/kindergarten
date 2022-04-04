<?php

namespace App\Repository;

use App\Component\StatisticMapper;
use App\Entity\Participant;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\DBAL\FetchMode;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method Participant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participant[]    findAll()
 * @method Participant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticipantRepository extends ServiceEntityRepository
{
    private $mapper;
    public function __construct(ManagerRegistry $registry, StatisticMapper $mapper)
    {
        $this->mapper = $mapper;
        parent::__construct($registry, Participant::class);
    }
    
    /**
     * @return int|mixed|string
     */
    public function getParticipantsForReport()
    {

        $connection = $this->getEntityManager()->getConnection();

        $stmt = $connection->prepare('SELECT
            k.name, p.*
            FROM participant AS p
            JOIN kindergarten AS k ON p.kindergarten_id = k.id');
        $stmt->execute();

        return $stmt->fetchAll(FetchMode::ASSOCIATIVE);
    }

    // /**
    //  * @return Participant[] Returns an array of Participant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Participant
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */


    public function getChartParticipants(): array
    {
        $qb = $this->getParticipantsForChart();

        return $this->prepareData($qb);
    }


    public function getSelectedData(Request $request): array
    {
        $kindergartenId = $request->get('kindergartenId');
        $gender = $request->get('gender');
        $dateFrom = $request->get('dateFrom');
        $dateTo = $request->get('dateTo');
        $ageFrom = $request->get('ageFrom');
        $ageTo = $request->get('ageTo');

        $qb = $this->getParticipantsForChart();

        $now = new DateTime('now');
        $from = clone($now);
        $to = clone($now);

        if($ageFrom != 'all' && $ageTo != 'all') {
            $from->modify('-'.$ageFrom.' year');
            $from->format('d.m.Y H:i');
            $to->modify('-'.$ageTo.' year');
            $to->format('d.m.Y H:i');
            $qb
                ->andWhere('p.birthAt < :from')
                ->andWhere('p.birthAt > :to')
                ->setParameter('from', $from)
                ->setParameter('to', $to);
        } elseif($ageFrom != 'all') {
            $from->modify('-'.$ageFrom.' year');
            $from->format('d.m.Y H:i');
            $qb
                ->andWhere('p.birthAt  < :from')
                ->setParameter('from', $from);
        } elseif($ageTo != 'all') {
            $to->modify('-'.$ageTo.' year');
            $to->format('d.m.Y H:i');
            $qb
                ->andWhere('p.birthAt  > :to')
                ->setParameter('to', $to);
        }

        if($gender !== 'all') {
            $qb
                ->andWhere('p.gender = :gender')
                ->setParameter('gender', $gender);
        }

        if($kindergartenId !== 'all') {
            $qb
                ->leftJoin('p.kindergarten', 'k')
                ->andWhere('k.id = :id')
                ->setParameter('id', $kindergartenId);
        }

        if($dateFrom != '' && $dateTo != '') {
            $from  = DateTime::createFromFormat('d.m.Y H:i', $dateFrom);
            $to  = DateTime::createFromFormat('d.m.Y H:i', $dateTo);

            $qb
                ->andWhere('p.finishedAt > :from')
                ->andWhere('p.finishedAt < :to')
                ->setParameter('from', $from)
                ->setParameter('to', $to);
        } elseif($dateFrom != '') {
            $from  = DateTime::createFromFormat('d.m.Y H:i', $dateFrom);
            $qb
                ->andWhere('p.finishedAt  > :from')
                ->setParameter('from', $from);
        } elseif($dateTo != '') {
            $to = DateTime::createFromFormat('d.m.Y H:i', $dateTo);
            $qb
                ->andWhere('p.finishedAt  < :to')
                ->setParameter('to', $to);
        }

        return $this->prepareData($qb);
    }

    private function getParticipantsForChart(): QueryBuilder
    {
        return $this->createQueryBuilder('p')
            ->select(
                '
                    p.statusFood,
                    p.statusNicotine,
                    p.statusImmune,
                    p.statusSleep,
                    p.statusDigital,
                    p.statusAdaptation,
                    p.statusExternal,
                    p.statusNewness,
                    p.statusFocus,
                    p.statusWeight,
                    p.statusActivity,
                    p.statusFitness
                '
            );
    }

    private function prepareData($qb): array
    {
        $response = $qb
            ->getQuery()
            ->getResult();

        $array = [];

        foreach($response as $element) {
            foreach($element as $status => $value) {
                if ($value !== null) {
                    if(!array_key_exists($status, $array)) {
                        $array[$status] = [];
                        $array[$status]['chartTextData'] = $this->mapper->getLegend()[$status];
                        $array[$status]['statistics'] = [];
                    }

                    if(!array_key_exists($value,  $array[$status]['statistics'])) {
                        $array[$status]['statistics'][$value] = 0;
                    }

                    $array[$status]['statistics'][$value] += 1;
                }
            }
        }

        return $array;
    }

}
