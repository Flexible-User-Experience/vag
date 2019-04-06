<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Knp\DoctrineBehaviors\Model as ORMBehaviors;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventCategoryRepository")
 * @UniqueEntity("name")
 */
class EventCategory extends AbstractEntity
{
    use ORMBehaviors\Translatable\Translatable;

    const DEFAULT_COLOR = '#2F2F2F';
    const DEFAULT_ICON = 'fa fa-question';

    /**
     * @ORM\Column(type="smallint")
     *
     * @var int
     */
    private $priority;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=1})
     *
     * @var bool
     */
    private $isAvailable;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $color;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $icon;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EventActivity", mappedBy="category")
     *
     * @var ArrayCollection
     */
    private $eventActivities;

    /**
     * Methods.
     */

    /**
     * EventCategory constructor.
     */
    public function __construct()
    {
        $this->eventActivities = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getPriority(): ?int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     *
     * @return EventCategory
     */
    public function setPriority(int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getIsAvailable(): ?bool
    {
        return $this->isAvailable;
    }

    /**
     * @return bool|null
     */
    public function isAvailable(): ?bool
    {
        return $this->getIsAvailable();
    }

    /**
     * @param bool $isAvailable
     *
     * @return EventCategory
     */
    public function setIsAvailable(bool $isAvailable): self
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getColor(): string
    {
        return $this->color ? $this->color : self::DEFAULT_COLOR;
    }

    /**
     * @param string $color
     *
     * @return $this
     */
    public function setColor(string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIcon(): string
    {
        return $this->icon ? $this->icon : self::DEFAULT_ICON;
    }

    /**
     * @param string $icon
     *
     * @return $this
     */
    public function setIcon(string $icon): self
    {
        $this->icon = $icon;

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
     * @return EventCategory
     */
    public function addEventActivity(EventActivity $eventActivity): self
    {
        if (!$this->eventActivities->contains($eventActivity)) {
            $this->eventActivities[] = $eventActivity;
            $eventActivity->setCategory($this);
        }

        return $this;
    }

    /**
     * @param EventActivity $eventActivity
     *
     * @return EventCategory
     */
    public function removeEventActivity(EventActivity $eventActivity): self
    {
        if ($this->eventActivities->contains($eventActivity)) {
            $this->eventActivities->removeElement($eventActivity);
            // set the owning side to null (unless already changed)
            if ($eventActivity->getCategory() === $this) {
                $eventActivity->setCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? $this->getName() : '---';
    }
}
