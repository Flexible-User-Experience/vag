<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\EmailTrait;
use App\Entity\Traits\GenderTrait;
use App\Entity\Traits\ImageAttributesTrait;
use App\Entity\Traits\LinkTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\PhoneTrait;
use App\Entity\Traits\ShortDescriptionTrait;
use App\Entity\Traits\ShowInHomepageTrait;
use App\Entity\Traits\SlugTrait;
use App\Entity\Traits\SurnameTrait;
use App\Entity\Translation\EventCollaboratorTranslation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventCollaboratorRepository")
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="fullname_idx", columns={"name", "surname"})})
 * @UniqueEntity(fields={"name", "surname"})
 * @Gedmo\TranslationEntity(class="App\Entity\Translation\EventCollaboratorTranslation")
 * @Vich\Uploadable
 */
class EventCollaborator extends AbstractEntity
{
    use GenderTrait, NameTrait, SurnameTrait, SlugTrait, EmailTrait, PhoneTrait, ImageAttributesTrait, ShortDescriptionTrait, DescriptionTrait, ShowInHomepageTrait, LinkTrait;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     *
     * @var int
     */
    private $gender;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $surname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name", "surname"})
     *
     * @var string
     */
    private $slug;

    /**
     * @Vich\UploadableField(mapping="collaborator", fileNameProperty="imageName", size="imageSize")
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
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(mode="strict")
     *
     * @var string
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $phone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url
     *
     * @var string
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Gedmo\Translatable
     *
     * @var string
     */
    private $shortDescription;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Gedmo\Translatable
     *
     * @var string
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=1})
     *
     * @var bool
     */
    private $showInHomepage;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\EventActivity", mappedBy="collaborators")
     *
     * @var ArrayCollection
     */
    private $eventActivities;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Translation\EventCollaboratorTranslation", mappedBy="object", cascade={"persist", "remove"})
     *
     * @var ArrayCollection
     */
    private $translations;

    /**
     * Methods.
     */

    /**
     * EventCollaborator constructor.
     */
    public function __construct()
    {
        $this->eventActivities = new ArrayCollection();
        $this->translations = new ArrayCollection();
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
     * @return EventCollaborator
     */
    public function addEventActivity(EventActivity $eventActivity): self
    {
        if (!$this->eventActivities->contains($eventActivity)) {
            $this->eventActivities[] = $eventActivity;
            $eventActivity->addCollaborator($this);
        }

        return $this;
    }

    /**
     * @param EventActivity $eventActivity
     *
     * @return EventCollaborator
     */
    public function removeEventActivity(EventActivity $eventActivity): self
    {
        if ($this->eventActivities->contains($eventActivity)) {
            $this->eventActivities->removeElement($eventActivity);
            $eventActivity->removeCollaborator($this);
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
     * @param EventCollaboratorTranslation $translation
     *
     * @return EventCollaborator
     */
    public function addTranslation(EventCollaboratorTranslation $translation)
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setObject($this);
        }

        return $this;
    }

    /**
     * @param EventCollaboratorTranslation $translation
     *
     * @return EventCollaborator
     */
    public function removeTranslation(EventCollaboratorTranslation $translation)
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
        return $this->id ? $this->getFullname() : '---';
    }
}
