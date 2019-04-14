<?php

namespace App\Entity\Traits;

/**
 * Trait ShowInFrontendTrait
 */
trait ShowInFrontendTrait
{
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
     * @param bool|null $showInFrontend
     *
     * @return $this
     */
    public function setShowInFrontend(?bool $showInFrontend): self
    {
        $this->showInFrontend = $showInFrontend;

        return $this;
    }
}
