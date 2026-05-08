<?php

declare(strict_types = 1);

namespace RfcTool\Service\Group\Creator;

final class UserBag
{
    private \DateTime            $beginDate;

    private ?\DateTime           $endDate = null;

    private \RfcTool\Entity\User $user;

    public function getBeginDate(): \DateTime
    {
        return $this->beginDate;
    }

    public function setBeginDate(\DateTime $beginDate): UserBag
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): UserBag
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getUser(): \RfcTool\Entity\User
    {
        return $this->user;
    }

    public function setUser(\RfcTool\Entity\User $user): UserBag
    {
        $this->user = $user;

        return $this;
    }
}