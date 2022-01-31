<?php

namespace App\Controller\Frontend;

use App\Component\Docxgen;
use App\Entity\Commune;
use App\Entity\County;
use App\Entity\Participant;
use App\Entity\School;
use App\Entity\Street;
use App\Entity\Town;
use App\Enum\GenderType;
use App\Form\Frontend\ParticipantType;
use App\Services\MailerService;
use App\Services\SettingsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TerytController
 * @package App\Controller\Frontend
 */
class TerytController extends AbstractController
{
    /**
     * @Route("/teryt/county-by-voivodeship", name="teryt.county.index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function countyAction(Request $request)
    {
        $items = $this->getDoctrine()
            ->getRepository(County::class)
            ->findBy([
                'voivodeship' => $request->get('id')
            ])
        ;

        $response = [];

        /** @var County $it */
        foreach ($items as $it) {
            $response[] = [
                'id' => $it->getId(),
                'name' => $it->getName()
            ];
        }

        return $this->json($response);
    }

    /**
     * @Route("/teryt/commune-by-county", name="teryt.commune.index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function communeAction(Request $request)
    {
        $items = $this->getDoctrine()
            ->getRepository(Commune::class)
            ->findBy([
                'county' => $request->get('id')
            ])
        ;

        $response = [];

        /** @var Commune $it */
        foreach ($items as $it) {
            $response[] = [
                'id' => $it->getId(),
                'name' => $it->getName(),
                'degurba' => $it->getDegurba()
            ];
        }

        return $this->json($response);
    }

    /**
     * @Route("/teryt/town-by-commune", name="teryt.town.index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function townAction(Request $request)
    {
        $items = $this->getDoctrine()
            ->getRepository(Town::class)
            ->findBy([
                'commune' => $request->get('id')
            ])
        ;

        $response = [];

        /** @var Town $it */
        foreach ($items as $it) {
            $response[] = [
                'id' => $it->getId(),
                'name' => $it->getName()
            ];
        }

        return $this->json($response);
    }

    /**
     * @Route("/teryt/street-by-town", name="teryt.street.index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function streetAction(Request $request)
    {
        $items = $this->getDoctrine()
            ->getRepository(Street::class)
            ->findBy([
                'town' => $request->get('id')
            ])
        ;

        $response = [];

        /** @var Street $it */
        foreach ($items as $it) {
            $response[] = [
                'id' => $it->getId(),
                'name' => $it->getName()
            ];
        }

        return $this->json($response);
    }
}
