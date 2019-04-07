<?php

namespace App\Controller\Front;

use App\Entity\EventActivity;
use App\Entity\EventCategory;
use App\Entity\EventCollaborator;
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
        $categories = $this->getDoctrine()->getRepository(EventCategory::class)->findAvailableSortedByPriorityAndName()->getQuery()->getResult();
        $mainHighlights = $this->getDoctrine()->getRepository(EventCollaborator::class)->findShowInHomepageSortedBySurnameAndName()->getQuery()->getResult();
        $secondaryHighlights = $this->getDoctrine()->getRepository(EventActivity::class)->findAvailableForHomepageSortedByBegin()->getQuery()->getResult();

        return $this->render('frontend/homepage.html.twig', [
            'categories' => $categories,
            'mainHighlights' => $mainHighlights,
            'secondaryHighlights' => $secondaryHighlights,
        ]);
    }

    /**
     * @Route("/test", name="front_test")
     *
     * @return Response
     */
    public function homepageTest()
    {
        return $this->render('frontend/homepage_test.html.twig', []);
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
     * @Route({"ca": "/entrades", "es": "/entradas", "en": "/tickets"}, name="front_tickets")
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
                'activities' => $this->getDoctrine()->getRepository(EventActivity::class)->findAvailableByCategorySortedByName($category)->getQuery()->getResult(),
            ]
        );
    }
}
