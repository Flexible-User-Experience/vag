<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\ImageAttributesTrait;
use App\Entity\Traits\IsAvailableTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\ShortDescriptionTrait;
use App\Entity\Traits\ShowInHomepageTrait;
use App\Entity\Traits\SlugTrait;
use App\Entity\Translation\EventActivityTranslation;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventActivityRepository")
 * @UniqueEntity("name")
 * @Gedmo\TranslationEntity(class="App\Entity\Translation\EventActivityTranslation")
 * @Vich\Uploadable
 */
class EventActivity extends AbstractEntity
{
    use NameTrait, SlugTrait, ImageAttributesTrait, ShortDescriptionTrait, DescriptionTrait, IsAvailableTrait, ShowInHomepageTrait;

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
     * @Vich\UploadableField(mapping="activity", fileNameProperty="imageName", size="imageSize")
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
     * @ORM\Column(type="datetime")
     *
     * @var DateTime
     */
    private $begin;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var DateTime
     */
    private $end;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Translatable
     *
     * @var string
     */
    private $shortDescription;

    /**
     * @ORM\Column(type="text")
     * @Gedmo\Translatable
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $language;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $target;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=1})
     *
     * @var bool
     */
    private $isAvailable;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=1})
     *
     * @var bool
     */
    private $showInHomepage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EventCategory", inversedBy="eventActivities")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var EventCategory
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EventLocation", inversedBy="eventActivities")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var EventLocation
     */
    private $location;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\EventCollaborator", inversedBy="eventActivities")
     *
     * @var ArrayCollection
     */
    private $collaborators;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Translation\EventActivityTranslation", mappedBy="object", cascade={"persist", "remove"})
     *
     * @var ArrayCollection
     */
    private $translations;

    /**
     * Methods.
     */

    /**
     * EventActivity constructor.
     */
    public function __construct()
    {
        $this->collaborators = new ArrayCollection();
        $this->translations = new ArrayCollection();
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getBegin(): ?DateTimeInterface
    {
        return $this->begin;
    }

    /**
     * @return string
     */
    public function getBeginString(): string
    {
        return $this->getBegin() ? $this->getBegin()->format('d/m/Y H:i') : '---';
    }

    /**
     * @param DateTimeInterface|null $begin
     *
     * @return EventActivity
     */
    public function setBegin(?DateTimeInterface $begin): self
    {
        $this->begin = $begin;

        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getEnd(): ?DateTimeInterface
    {
        return $this->end;
    }

    /**
     * @return string
     */
    public function getEndString(): string
    {
        return $this->getEnd() ? $this->getEnd()->format('d/m/Y H:i') : '---';
    }

    /**
     * @param DateTimeInterface|null $end
     *
     * @return EventActivity
     */
    public function setEnd(?DateTimeInterface $end): self
    {
        $this->end = $end;

        return $this;
    }

    /**
     * @return bool
     */
    public function isOnlyOneDayLong(): bool
    {
        $result = false;
        if ($this->getBegin() && $this->getEnd() && $this->getBegin()->format('d/m/Y') === $this->getEnd()->format('d/m/Y')) {
            $result = true;
        }

        return $result;
    }

    /**
     * @return string|null
     */
    public function getLanguage(): ?string
    {
        return $this->language;
    }

    /**
     * @param string|null $language
     *
     * @return EventActivity
     */
    public function setLanguage(?string $language): self
    {
        $this->language = $language;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTarget(): ?string
    {
        return $this->target;
    }

    /**
     * @param string|null $target
     *
     * @return EventActivity
     */
    public function setTarget(?string $target): self
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @return EventCategory|null
     */
    public function getCategory(): ?EventCategory
    {
        return $this->category;
    }

    /**
     * @param EventCategory|null $category
     *
     * @return EventActivity
     */
    public function setCategory(?EventCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return EventLocation|null
     */
    public function getLocation(): ?EventLocation
    {
        return $this->location;
    }

    /**
     * @param EventLocation|null $location
     *
     * @return EventActivity
     */
    public function setLocation(?EventLocation $location): self
    {
        $this->location = $location;

        return $this;
    }

    /**
     * @return Collection|EventCollaborator[]
     */
    public function getCollaborators(): Collection
    {
        return $this->collaborators;
    }

    /**
     * @param EventCollaborator $collaborator
     *
     * @return EventActivity
     */
    public function addCollaborator(EventCollaborator $collaborator): self
    {
        if (!$this->collaborators->contains($collaborator)) {
            $this->collaborators[] = $collaborator;
        }

        return $this;
    }

    /**
     * @param EventCollaborator $collaborator
     *
     * @return EventActivity
     */
    public function removeCollaborator(EventCollaborator $collaborator): self
    {
        if ($this->collaborators->contains($collaborator)) {
            $this->collaborators->removeElement($collaborator);
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
     * @param EventActivityTranslation $translation
     *
     * @return EventActivity
     */
    public function addTranslation(EventActivityTranslation $translation)
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setObject($this);
        }

        return $this;
    }

    /**
     * @param EventActivityTranslation $translation
     *
     * @return EventActivity
     */
    public function removeTranslation(EventActivityTranslation $translation)
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
