<?php

declare(strict_types = 1);

namespace RfcTool\Service\User\Creator;

final class GroupBag
{
    private \DateTime             $beginDate;

    private ?\DateTime            $endDate = null;

    private \RfcTool\Entity\Group $group;

    public function getBeginDate(): \DateTime
    {
        return $this->beginDate;
    }

    public function setBeginDate(\DateTime $beginDate): GroupBag
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTime $endDate): GroupBag
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getGroup(): \RfcTool\Entity\Group
    {
        return $this->group;
    }

    public function setGroup(\RfcTool\Entity\Group $group): GroupBag
    {
        $this->group = $group;

        return $this;
    }
}