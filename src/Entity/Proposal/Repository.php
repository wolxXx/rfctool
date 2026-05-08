<?php

declare(strict_types=1);

namespace RfcTool\Entity\Proposal;

class Repository extends \Doctrine\ORM\EntityRepository
{
    use \RfcTool\Entity\Share\Timestampable;
    use \RfcTool\Entity\Share\Blameable;

    public function create(\RfcTool\Entity\Proposal $entity): static
    {
        $this
            ->onCreateTS(model: $entity)
            ->onCreate(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function update(\RfcTool\Entity\Proposal $entity): static
    {
        $this
            ->onUpdate(model: $entity)
            ->onUpdateTS(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function delete(\RfcTool\Entity\Proposal $entity): static
    {
        $this
            ->getEntityManager()
            ->remove(object: $entity)
        ;

        return $this;
    }
}
