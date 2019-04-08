<?php

namespace App\Entity;

use App\Entity\Traits\NameTrait;
use App\Entity\Translation\EventCollaboratorTranslation;
use Exception;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
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
    use NameTrait;

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
     * @return int|null
     */
    public function getGender(): ?int
    {
        return $this->gender;
    }

    /**
     * @param int $gender
     *
     * @return EventCollaborator
     */
    public function setGender(int $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     *
     * @return EventCollaborator
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFullname(): ?string
    {
        return $this->name.' '.$this->surname;
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
     * @return EventCollaborator
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    /**
     * @param File $imageFile
     *
     * @return EventCollaborator
     * @throws Exception
     */
    public function setImageFile(?File $imageFile): self
    {
        $this->imageFile = $imageFile;
        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated = new DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    /**
     * @param string $imageName
     *
     * @return EventCollaborator
     */
    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    /**
     * @param int $imageSize
     *
     * @return EventCollaborator
     */
    public function setImageSize(?int $imageSize): self
    {
        $this->imageSize = $imageSize;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     *
     * @return EventCollaborator
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * @param string|null $phone
     *
     * @return EventCollaborator
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string $link
     *
     * @return EventCollaborator
     */
    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     *
     * @return EventCollaborator
     */
    public function setShortDescription(string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return EventCollaborator
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getShowInHomepage(): ?bool
    {
        return $this->showInHomepage;
    }

    /**
     * @return bool|null
     */
    public function isShowInHomepage(): ?bool
    {
        return $this->getShowInHomepage();
    }

    /**
     * @param bool $showInHomepage
     *
     * @return EventCollaborator
     */
    public function setShowInHomepage(bool $showInHomepage): self
    {
        $this->showInHomepage = $showInHomepage;

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
