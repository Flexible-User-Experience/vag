<?php

namespace App\Entity\Traits;

/**
 * Trait ShowInHomepageTrait
 */
trait ShowInHomepageTrait
{
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
     * @param bool|null $showInHomepage
     *
     * @return $this
     */
    public function setShowInHomepage(?bool $showInHomepage): self
    {
        $this->showInHomepage = $showInHomepage;

        return $this;
    }
}
