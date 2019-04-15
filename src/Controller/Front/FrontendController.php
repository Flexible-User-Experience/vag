<?php

namespace App\Controller\Front;

use App\Entity\EventActivity;
use App\Entity\EventCategory;
use App\Entity\EventCollaborator;
use App\Entity\TeamMember;
use App\Entity\TeamPartner;
use App\Enum\UserRoleEnum;
use Doctrine\ORM\NonUniqueResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
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
        $featuredSpeakers = $this->getDoctrine()->getRepository(EventCollaborator::class)->findShowInHomepageSortedBySurnameAndName()->getQuery()->getResult();
        $featuredActivities = $this->getDoctrine()->getRepository(EventActivity::class)->findAvailableForHomepageSortedByBegin()->getQuery()->getResult();

        return $this->render('frontend/homepage.html.twig', [
            'categories' => $categories,
            'featuredSpeakers' => $featuredSpeakers,
            'featuredActivities' => $featuredActivities,
        ]);
    }

    /**
     * @Route("/test", name="front_test")
     *
     * @return Response|AccessDeniedException
     */
    public function homepageTest()
    {
        return !$this->get('security.authorization_checker')->isGranted(UserRoleEnum::ROLE_CMS) ? $this->createAccessDeniedException() : $this->render('frontend/homepage_test.html.twig', []);
    }

    /**
     * @Route({"ca": "/noticies", "es": "/noticias", "en": "/news"}, name="front_blog")
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
     * @Route({"ca": "/contacte", "es": "/contacto", "en": "/contact"}, name="front_contact")
     *
     * @return Response
     */
    public function contact()
    {
        return $this->render('frontend/contact.html.twig', []);
    }

    /**
     * @Route({"ca": "/equip", "es": "/equipo", "en": "/team"}, name="front_team")
     *
     * @return Response
     */
    public function team()
    {
        $members = $this->getDoctrine()->getRepository(TeamMember::class)->findShowInFrontendSortedBySurnameAndName()->getQuery()->getResult();
        $partners = $this->getDoctrine()->getRepository(TeamPartner::class)->findShowInFrontendSortedByName()->getQuery()->getResult();

        return $this->render('frontend/team.html.twig', [
            'members' => $members,
            'partners' => $partners,
        ]);
    }

    /**
     * @Route({"ca": "/participants", "es": "/participantes", "en": "/participants"}, name="front_participants")
     *
     * @return Response
     */
    public function participants()
    {
        $participants = $this->getDoctrine()->getRepository(EventCollaborator::class)->findAllSortedBySurnameAndName()->getQuery()->getResult();

        return $this->render('frontend/participants.html.twig', [
            'participants' => $participants,
        ]);
    }

    /**
     * @Route({"ca": "/activitats", "es": "/actividades", "en": "/activities"}, name="front_activities")
     *
     * @return Response
     */
    public function activities()
    {
        $activities = [];
        $categories = $this->getDoctrine()->getRepository(EventCategory::class)->findAvailableSortedByPriorityAndName()->getQuery()->getResult();
        /** @var EventCategory $category */
        foreach ($categories as $category) {
            $activities[$category->getSlug()] = $this->getDoctrine()->getRepository(EventActivity::class)->findAvailableByCategorySortedByName($category)->getQuery()->getResult();
        }

        return $this->render('frontend/activities.html.twig', [
            'categories' => $categories,
            'activities' => $activities,
        ]);
    }

    /**
     * @Route({"ca": "/participant/{slug}", "es": "/participante/{slug}", "en": "/participant/{slug}"}, name="front_participant_detail")
     * @ParamConverter("participant", class="App:EventCollaborator")
     *
     * @param EventCollaborator $participant
     *
     * @return Response
     */
    public function participantDetail(EventCollaborator $participant)
    {
        return $this->render('frontend/participant.html.twig', [
            'participant' => $participant,
        ]);
    }

    /**
     * @Route("/{slug}", name="front_event_category")
     *
     * @param string $slug
     * @param string $defaultLocale
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws NonUniqueResultException
     */
    public function category(string $slug, string $defaultLocale)
    {
        $locale = $this->get('request_stack')->getCurrentRequest()->getLocale();
        if ($locale === $defaultLocale) {
            $category = $this->getDoctrine()->getRepository(EventCategory::class)->findOneBy(['slug' => $slug]);
        } else {
            $category = $this->getDoctrine()->getRepository(EventCategory::class)->findByLocalizedSlugAvailableSortedByPriorityAndName($locale, $slug)->getQuery()->getOneOrNullResult();
        }

        if (!$category) {
            throw $this->createNotFoundException();
        }
        if (!$category->isAvailable() && !$this->get('security.authorization_checker')->isGranted(UserRoleEnum::ROLE_CMS)) {
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

    /**
     * @Route({"ca": "/{category}/activitat/{activity}", "es": "/{category}/actividad/{activity}", "en": "/{category}/activity/{activity}"}, name="front_event_activity")
     * @ParamConverter("category", class="App:EventCategory", options={"mapping": {"category": "slug"}})
     * @ParamConverter("activity", class="App:EventActivity", options={"mapping": {"activity": "slug"}})
     *
     * @param EventCategory $category
     * @param EventActivity $activity
     *
     * @return Response
     * @throws NotFoundHttpException
     */
    public function activity(EventCategory $category, EventActivity $activity)
    {
        if (!$category->isAvailable() && !$this->get('security.authorization_checker')->isGranted(UserRoleEnum::ROLE_CMS)) {
            throw $this->createNotFoundException();
        }
        if ($activity->getCategory()->getSlug() !== $category->getSlug()) {
            throw $this->createNotFoundException();
        }
        if (!$activity->isAvailable() && !$this->get('security.authorization_checker')->isGranted(UserRoleEnum::ROLE_CMS)) {
            throw $this->createNotFoundException();
        }

        return $this->render(
            'frontend/activity.html.twig',
            [
                'category' => $category,
                'activity' => $activity,
            ]
        );
    }
}
