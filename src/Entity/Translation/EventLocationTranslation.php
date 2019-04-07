<?php

namespace App\Entity\Translation;

use App\Entity\EventLocation;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity()
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="event_location_lookup_unique_idx", columns={"locale", "object_id", "field"})})
 */
class EventLocationTranslation extends AbstractPersonalTranslation
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EventLocation", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @var EventLocation
     */
    protected $object;
}
