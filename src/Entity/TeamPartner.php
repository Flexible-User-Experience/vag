<?php

namespace App\Entity;

use App\Entity\Traits\ImageAttributesTrait;
use App\Entity\Traits\LinkNameTrait;
use App\Entity\Traits\LinkTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\ShowInFrontendTrait;
use App\Entity\Traits\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamPartnerRepository")
 * @ORM\Table()
 * @UniqueEntity(fields={"name"})
 * @Vich\Uploadable
 */
class TeamPartner extends AbstractEntity
{
    use NameTrait, SlugTrait, ImageAttributesTrait, LinkTrait, LinkNameTrait, ShowInFrontendTrait;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Gedmo\Slug(fields={"name"})
     *
     * @var string
     */
    private $slug;

    /**
     * @Vich\UploadableField(mapping="partner", fileNameProperty="imageName", size="imageSize")
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
     * @Assert\Url
     *
     * @var string
     */
    private $link;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $linkName;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=1})
     *
     * @var bool
     */
    private $showInFrontend;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=0})
     *
     * @var bool
     */
    private $isCollaborator;

    /**
     * Methods.
     */

    /**
     * @return bool|null
     */
    public function getIsCollaborator(): ?bool
    {
        return $this->isCollaborator;
    }

    /**
     * @return bool|null
     */
    public function isCollaborator(): ?bool
    {
        return $this->getIsCollaborator();
    }

    /**
     * @param bool|null $isCollaborator
     *
     * @return $this
     */
    public function setIsCollaborator(?bool $isCollaborator): self
    {
        $this->isCollaborator = $isCollaborator;

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
