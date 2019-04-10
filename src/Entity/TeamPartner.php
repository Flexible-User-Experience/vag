<?php

namespace App\Entity;

use App\Entity\Traits\ImageAttributesTrait;
use App\Entity\Traits\LinkTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\SlugTrait;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TeamPartnerRepository")
 * @ORM\Table()
 * @UniqueEntity(fields={"name"})
 * @Vich\Uploadable
 */
class TeamPartner extends AbstractEntity
{
    use NameTrait, SlugTrait, ImageAttributesTrait, LinkTrait;

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
     *
     * @var string
     */
    private $link;

    /**
     * @ORM\Column(type="boolean", nullable=true, options={"default"=1})
     *
     * @var bool
     */
    private $showInFrontend;

    /**
     * Methods.
     */

    /**
     * @return bool|null
     */
    public function getShowInFrontend(): ?bool
    {
        return $this->showInFrontend;
    }

    /**
     * @return bool|null
     */
    public function isShowInFrontend(): ?bool
    {
        return $this->getShowInFrontend();
    }

    /**
     * @param bool $showInFrontend
     *
     * @return TeamPartner
     */
    public function setShowInFrontend(bool $showInFrontend): self
    {
        $this->showInFrontend = $showInFrontend;

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
