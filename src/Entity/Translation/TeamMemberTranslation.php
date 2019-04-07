<?php

namespace App\Entity\Translation;

use App\Entity\TeamMember;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * @ORM\Entity()
 * @ORM\Table(uniqueConstraints={@ORM\UniqueConstraint(name="team_member_lookup_unique_idx", columns={"locale", "object_id", "field"})})
 */
class TeamMemberTranslation extends AbstractPersonalTranslation
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TeamMember", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     *
     * @var TeamMember
     */
    protected $object;
}
