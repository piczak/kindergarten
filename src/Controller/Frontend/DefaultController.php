<?php

namespace App\Controller\Frontend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Services\SettingsService;

class DefaultController extends AbstractController
{
    private $settingsService;
    
    public function __construct(
        SettingsService $settingsService
    ) {
        $this->settingsService = $settingsService;
    }
    
    /**
     * @Route("/", name="frontend.index")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
        $sett = $this->settingsService;
        
        return $this->render('frontend/index.html.twig', [
            'sett' => $sett
        ]);
    }
}
