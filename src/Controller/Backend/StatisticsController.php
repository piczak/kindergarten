<?php

namespace App\Controller\Backend;

use App\DataTable\Backend\ParticipantTableType;
use App\Entity\Kindergarten;
use App\Entity\Participant;
use League\Csv\Writer;
use League\Csv\ByteSequence;
use App\Form\Backend\ParticipantType;
use App\Form\Backend\SchoolType;
use Omines\DataTablesBundle\DataTableFactory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class StatisticsController
 * @package App\Controller\Backend
 */
class StatisticsController extends AbstractController
{
    /**
     * @var DataTableFactory
     */
    protected $dataTable;

    /**
     * StatisticsController constructor.
     * @param DataTableFactory $dataTable
     */
    public function __construct(DataTableFactory $dataTable)
    {
        $this->dataTable = $dataTable;
    }

    /**
     * @Route("/admin/statistics", name="admin.statistics.index")
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $statisticsData = $this->getDoctrine()
            ->getRepository(Participant::class)
            ->getChartParticipants();

        $kindergarten = $this->getDoctrine()
            ->getRepository(Kindergarten::class)
            ->getAllKindergarten();

        return $this->render('backend/statistics/index.html.twig', [
            'statisticsData' => $statisticsData, 'kindergarten' => $kindergarten
        ]);
    }

    /**
     * @Route("/admin/statistics/update", name="admin.statistics.update", options={"expose"=true})
     * @param Request $request
     * @return JsonResponse
     */
    public function updateAction(Request $request): JsonResponse
    {
        $statisticsData = $this->getDoctrine()
            ->getRepository(Participant::class)
            ->getSelectedData($request);


        $result = [
            'status' => 'success',
            'message' => $statisticsData
        ];

        return $this->json($result);
    }
}
