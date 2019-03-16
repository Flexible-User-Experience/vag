<?php

namespace App\Controller;

use App\Entity\EventCategory;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @Route("/blog", name="front_blog")
     *
     * @return Response
     */
    public function blog()
    {
        return $this->render('frontend/blog.html.twig', []);
    }

    /**
     * @Route("/tickets", name="front_tickets")
     *
     * @return Response
     */
    public function tickets()
    {
        return $this->render('frontend/tickets.html.twig', []);
    }

    /**
     * @Route("/{slug}", name="front_event_category")
     * @ParamConverter("category", class="App:EventCategory")
     *
     * @param EventCategory $category
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function category(EventCategory $category)
    {
        if (!$category->isAvailable()) { // TODO disable for admin logged users
            throw $this->createNotFoundException();
        }

        return $this->render(
            'frontend/category.html.twig',
            [
                'category' => $category,
            ]
        );
    }
}
