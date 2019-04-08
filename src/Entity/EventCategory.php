<?php

namespace App\Entity;

use App\Entity\Traits\ImageAttributesTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\SlugTrait;
use App\Entity\Translation\EventCategoryTranslation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventCategoryRepository")
 * @UniqueEntity("name")
 * @Gedmo\TranslationEntity(class="App\Entity\Translation\EventCategoryTranslation")
 * @Vich\Uploadable
 */
class EventCategory extends AbstractEntity
{
    use NameTrait, SlugTrait, ImageAttributesTrait;

    const DEFAULT_COLOR = '#2F2F2F';
    const DEFAULT_ICON = 'fa fa-question';

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Gedmo\Translatable
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     * @Gedmo\Translatable
     *
     * @var string
     */
    private $slug;

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
     * @Vich\UploadableField(mapping="category", fileNameProperty="imageName", size="imageSize")
     *
     * @var File
     */
    private $imageFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $imageName;

    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     * @var integer
     */
    private $imageSize;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\EventActivity", mappedBy="category")
     *
     * @var ArrayCollection
     */
    private $eventActivities;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Translation\EventCategoryTranslation", mappedBy="object", cascade={"persist", "remove"})
     *
     * @var ArrayCollection
     */
    private $translations;

    /**
     * Methods.
     */

    /**
     * EventCategory constructor.
     */
    public function __construct()
    {
        $this->eventActivities = new ArrayCollection();
        $this->translations = new ArrayCollection();
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
     * @return EventCategory
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
     * @return EventCategory
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
     * @return Collection
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    /**
     * @param EventCategoryTranslation $translation
     *
     * @return EventCategory
     */
    public function addTranslation(EventCategoryTranslation $translation)
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setObject($this);
        }

        return $this;
    }

    /**
     * @param EventCategoryTranslation $translation
     *
     * @return EventCategory
     */
    public function removeTranslation(EventCategoryTranslation $translation)
    {
        if ($this->translations->contains($translation)) {
            $this->translations->removeElement($translation);
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
