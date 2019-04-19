<?php

namespace App\Entity;

use App\Entity\Traits\DescriptionTrait;
use App\Entity\Traits\EmailTrait;
use App\Entity\Traits\GenderTrait;
use App\Entity\Traits\ImageAttributesTrait;
use App\Entity\Traits\JobTrait;
use App\Entity\Traits\LinkTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\PhoneTrait;
use App\Entity\Traits\ShowInFrontendTrait;
use App\Entity\Traits\SlugTrait;
use App\Entity\Traits\SurnameTrait;
use App\Entity\Translation\TeamMemberTranslation;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamMemberRepository")
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="team_fullname_idx", columns={"name", "surname"})})
 * @UniqueEntity(fields={"name", "surname"})
 * @Gedmo\TranslationEntity(class="App\Entity\Translation\TeamMemberTranslation")
 * @Vich\Uploadable
 */
class TeamMember extends AbstractEntity
{
    use GenderTrait, NameTrait, SurnameTrait, SlugTrait, EmailTrait, PhoneTrait, ImageAttributesTrait, JobTrait, DescriptionTrait, LinkTrait, ShowInFrontendTrait;

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
     * @Vich\UploadableField(mapping="team", fileNameProperty="imageName", size="imageSize")
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
     * @ORM\Column(type="string", length=255, nullable=true)
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
    private $job;

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
    private $showInFrontend;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Translation\TeamMemberTranslation", mappedBy="object", cascade={"persist", "remove"})
     *
     * @var ArrayCollection
     */
    private $translations;

    /**
     * Methods.
     */

    /**
     * TeamMember constructor.
     */
    public function __construct()
    {
        $this->translations = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getTranslations(): Collection
    {
        return $this->translations;
    }

    /**
     * @param TeamMemberTranslation $translation
     *
     * @return TeamMember
     */
    public function addTranslation(TeamMemberTranslation $translation)
    {
        if (!$this->translations->contains($translation)) {
            $this->translations[] = $translation;
            $translation->setObject($this);
        }

        return $this;
    }

    /**
     * @param TeamMemberTranslation $translation
     *
     * @return TeamMember
     */
    public function removeTranslation(TeamMemberTranslation $translation)
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
