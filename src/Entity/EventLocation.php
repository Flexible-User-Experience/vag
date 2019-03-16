<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventLocationRepository")
 * @UniqueEntity("place")
 */
class EventLocation extends AbstractEntity
{
    /**
     * @ORM\Column(type="string", length=255, unique=true)
     *
     * @var string
     */
    private $place;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"place"})
     *
     * @var string
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EventActivity", mappedBy="location")
     *
     * @var ArrayCollection
     */
    private $eventActivities;

    /**
     * Methods.
     */

    /**
     * EventLocation constructor.
     */
    public function __construct()
    {
        $this->eventActivities = new ArrayCollection();
    }

    /**
     * @return string|null
     */
    public function getPlace(): ?string
    {
        return $this->place;
    }

    /**
     * @param string $place
     *
     * @return EventLocation
     */
    public function setPlace(string $place): self
    {
        $this->place = $place;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     *
     * @return EventLocation
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|EventActivity[]
     */
    public function getEventActivities(): Collection
    {
        return $this->eventActivities;
    }

    /**
     * @param EventActivity $eventActivity
     *
     * @return EventLocation
     */
    public function addEventActivity(EventActivity $eventActivity): self
    {
        if (!$this->eventActivities->contains($eventActivity)) {
            $this->eventActivities[] = $eventActivity;
            $eventActivity->setLocation($this);
        }

        return $this;
    }

    /**
     * @param EventActivity $eventActivity
     *
     * @return EventLocation
     */
    public function removeEventActivity(EventActivity $eventActivity): self
    {
        if ($this->eventActivities->contains($eventActivity)) {
            $this->eventActivities->removeElement($eventActivity);
            // set the owning side to null (unless already changed)
            if ($eventActivity->getLocation() === $this) {
                $eventActivity->setLocation(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getPlace() : '---';
    }
}
