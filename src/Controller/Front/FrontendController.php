<?php

namespace App\Controller\Front;

use App\Entity\ContactMessage;
use App\Entity\EventActivity;
use App\Entity\EventCategory;
use App\Entity\EventCollaborator;
use App\Entity\EventLocation;
use App\Entity\TeamMember;
use App\Entity\TeamPartner;
use App\Enum\UserRoleEnum;
use App\Form\ContactMessageType;
use App\Manager\EventActivityManager;
use App\Manager\EventCategoryManager;
use App\Service\EmailSendingService;
use Doctrine\ORM\NonUniqueResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/", requirements={"_locale"="%app_locales%"})
 */
class FrontendController extends AbstractController
{
    /**
     * @Route("/", name="front_homepage")
     *
     * @param EventCategoryManager $ecm
     *
     * @return Response
     */
    public function homepage(EventCategoryManager $ecm)
    {
        $categories = $ecm->getAvailableSortedByPriorityAndName();
        $featuredSpeakers = $this->getDoctrine()->getRepository(EventCollaborator::class)->findShowInHomepageSortedBySurnameAndName()->getQuery()->getResult();
        $featuredActivities = $this->getDoctrine()->getRepository(EventActivity::class)->findAvailableForHomepageSortedByBegin()->getQuery()->getResult();
        $featuredLocations = $this->getDoctrine()->getRepository(EventLocation::class)->findShowInHomepageSortedByPlace()->getQuery()->getResult();

        return $this->render('frontend/homepage.html.twig', [
            'categories' => $categories,
            'featuredSpeakers' => $featuredSpeakers,
            'featuredActivities' => $featuredActivities,
            'featuredLocations' => $featuredLocations,
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
     * @param Request             $request
     * @param TranslatorInterface $translator
     * @param EmailSendingService $ess
     *
     * @return Response
     */
    public function contact(Request $request, TranslatorInterface $translator, EmailSendingService $ess)
    {
        $hideForm = false;
        $contactMessage = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contactMessage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactMessage
                ->setLegalTermsHasBeenAccepted(true)
                ->setSubject('front_contact')
            ;
            $em = $this->getDoctrine()->getManager();
            $em->persist($contactMessage);
            $em->flush();
            $this->addFlash(
                'success',
                $translator->trans('front.flash.contact_message_send')
            );
            $ess->sendFrontendContactMessageNotificationToAdmin($contactMessage);
            $hideForm = true;
        }

        return $this->render('frontend/contact.html.twig', [
            'form' => $form->createView(),
            'hideForm' => $hideForm,
        ]);
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
     * @Route({"ca": "/participants", "es": "/participantes", "en": "/participants"}, name="front_collaborators")
     *
     * @return Response
     */
    public function collaborators()
    {
        $participants = $this->getDoctrine()->getRepository(EventCollaborator::class)->findAllSortedBySurnameAndName()->getQuery()->getResult();

        return $this->render('frontend/collaborators.html.twig', [
            'participants' => $participants,
        ]);
    }

    /**
     * @Route({"ca": "/ubicacions", "es": "/ubicaciones", "en": "/locations"}, name="front_locations")
     *
     * @return Response
     */
    public function locations()
    {
        $locations = $this->getDoctrine()->getRepository(EventLocation::class)->findAllSortedByPlace()->getQuery()->getResult();

        return $this->render('frontend/locations.html.twig', [
            'locations' => $locations,
        ]);
    }

    /**
     * @Route({"ca": "/activitats", "es": "/actividades", "en": "/activities"}, name="front_activities")
     *
     * @param EventCategoryManager $ecm
     *
     * @return Response
     */
    public function activities(EventCategoryManager $ecm)
    {
        $activities = [];
        $categories = $ecm->getAvailableSortedByPriorityAndName();
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
     * @Route({"ca": "/participant/{slug}", "es": "/participante/{slug}", "en": "/participant/{slug}"}, name="front_collaborator_detail")
     * @ParamConverter("participant", class="App:EventCollaborator")
     *
     * @param EventCollaborator $participant
     *
     * @return Response
     */
    public function collaboratorDetail(EventCollaborator $participant)
    {
        return $this->render('frontend/collaborator.html.twig', [
            'participant' => $participant,
        ]);
    }

    /**
     * @Route({"ca": "/ubicacio/{slug}", "es": "/ubicacion/{slug}", "en": "/location/{slug}"}, name="front_location_detail")
     * @ParamConverter("location", class="App:EventLocation")
     *
     * @param EventLocation $location
     *
     * @return Response
     */
    public function locationDetail(EventLocation $location)
    {
        return $this->render('frontend/location.html.twig', [
            'location' => $location,
        ]);
    }

    /**
     * @Route("/{slug}", name="front_event_category")
     *
     * @param string $slug
     * @param EventCategoryManager $ecm
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws NonUniqueResultException
     */
    public function category(string $slug, EventCategoryManager $ecm)
    {
        $category = $ecm->getCategoryByTranslatedSlug($slug);
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
     *
     * @param string $category
     * @param string $activity
     * @param EventCategoryManager $ecm
     * @param EventActivityManager $eam
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws NonUniqueResultException
     */
    public function activity(string $category, string $activity, EventCategoryManager $ecm, EventActivityManager $eam)
    {
        $category = $ecm->getCategoryByTranslatedSlug($category);
        if (!$category) {
            throw $this->createNotFoundException();
        }
        if (!$category->isAvailable() && !$this->get('security.authorization_checker')->isGranted(UserRoleEnum::ROLE_CMS)) {
            throw $this->createNotFoundException();
        }
        $activity = $eam->getActivityByTranslatedSlug($activity);
        if (!$activity) {
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
