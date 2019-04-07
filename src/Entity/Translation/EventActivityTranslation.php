<?php

namespace App\Entity\Translation;

use App\Entity\EventActivity;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity()
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="event_activity_lookup_unique_idx", columns={"locale", "object_id", "field"})})
 */
class EventActivityTranslation extends AbstractPersonalTranslation
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\EventActivity", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @var EventActivity
     */
    protected $object;
}
