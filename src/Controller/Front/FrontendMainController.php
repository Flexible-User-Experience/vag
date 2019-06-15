<?php

namespace App\Controller\Front;

use App\Entity\ContactNewsletter;
use App\Entity\EventCategory;
use App\Entity\EventCollaborator;
use App\Entity\EventLocation;
use App\Enum\UserRoleEnum;
use App\Form\ContactNewsletterType;
use App\Manager\EventActivityManager;
use App\Manager\EventCategoryManager;
use Doctrine\ORM\NonUniqueResultException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * @Route("/", requirements={"_locale"="%app_locales%"})
 */
class FrontendMainController extends AbstractController
{
    /**
     * @param Request $request
     * @param TranslatorInterface $translator
     *
     * @return Response
     */
    public function contactNewsletterFragment(Request $request, TranslatorInterface $translator)
    {
        $contactNewsletter = new ContactNewsletter();
        $form = $this->createForm(ContactNewsletterType::class, $contactNewsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactNewsletter
                ->setLegalTermsHasBeenAccepted(true)
                ->setIsAvailable(true)
            ;
            $em = $this->getDoctrine()->getManager();
            $em->persist($contactNewsletter);
            $em->flush();
            $this->addFlash(
                'success',
                $translator->trans('front.flash.contact_newsletter_send')
            );
//            $ess->sendFrontendContactMessageNotificationToAdmin($contactMessage);
            $hideForm = true;
        }

        return $this->render('frontend/fragments/contact_newsletter.html.twig', [
            'form' => $form->createView(),
//            'hideForm' => $hideForm,
        ]);
    }

    /**
     * @Route("/", name="front_homepage")
     *
     * @param EventCategoryManager $ecm
     * @param EventActivityManager $eam
     *
     * @return Response
     */
    public function homepage(EventCategoryManager $ecm, EventActivityManager $eam)
    {
        $categories = $ecm->getAvailableSortedByPriorityAndName();
        $featuredSpeakers = $this->getDoctrine()->getRepository(EventCollaborator::class)->findShowInHomepageSortedBySurnameAndName()->getQuery()->getResult();
        $featuredActivities = $eam->getAvailableForHomepageSortedByBegin();
        $featuredLocations = $this->getDoctrine()->getRepository(EventLocation::class)->findShowInHomepageSortedByPlace()->getQuery()->getResult();

        return $this->render('frontend/homepage.html.twig', [
            'categories' => $categories,
            'featuredSpeakers' => $featuredSpeakers,
            'featuredActivities' => $featuredActivities,
            'featuredLocations' => $featuredLocations,
        ]);
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
     * @param EventActivityManager $eam
     *
     * @return Response
     */
    public function activities(EventCategoryManager $ecm, EventActivityManager $eam)
    {
        $activities = [];
        $categories = $ecm->getAvailableSortedByPriorityAndName();
        /** @var EventCategory $category */
        foreach ($categories as $category) {
            $activities[$category->getSlug()] = $eam->getAvailableByCategorySortedByName($category);
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
     * @param EventActivityManager $eam
     *
     * @return Response
     * @throws NotFoundHttpException
     * @throws NonUniqueResultException
     */
    public function category(string $slug, EventCategoryManager $ecm, EventActivityManager $eam)
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
                'activities' => $eam->getAvailableByCategorySortedByName($category),
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
