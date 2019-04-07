<?php

namespace App\Entity\Translation;

use App\Entity\EventCollaborator;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity()
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="event_collaborator_lookup_unique_idx", columns={"locale", "object_id", "field"})})
 */
class EventCollaboratorTranslation extends AbstractPersonalTranslation
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EventCollaborator", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @var EventCollaborator
     */
    protected $object;
}
