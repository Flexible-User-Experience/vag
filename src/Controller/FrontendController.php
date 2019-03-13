<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class FrontendController
 */
class FrontendController extends AbstractController
{
    /**
     * @Route("/")
     *
     * @return Response
     */
    public function number()
    {
        return $this->render('frontend/homepage.html.twig', []);
    }
}
