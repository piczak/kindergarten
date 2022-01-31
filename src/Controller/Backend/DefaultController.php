<?php

namespace App\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package App\Controller\Backend
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/admin/", name="admin")
     * @Route("/admin/", name="admin.dashboard")
     * @Route("/admin/", name="admin.index")
     */
    public function indexAction()
    {
        return $this->render('backend/dashboard.html.twig');
    }
}
