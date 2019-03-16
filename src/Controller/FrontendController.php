<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/")
 */
class FrontendController extends AbstractController
{
    /**
     * @Route("/", name="front_homepage")
     *
     * @return Response
     */
    public function homepage()
    {
        return $this->render('frontend/homepage.html.twig', []);
    }

    /**
     * @Route("/{category}", name="front_event_category")
     *
     * @param string $category
     *
     * @return Response
     */
    public function category($category)
    {
        return $this->render('frontend/homepage.html.twig', []);
    }
}
