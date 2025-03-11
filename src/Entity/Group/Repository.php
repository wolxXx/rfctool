<?php

declare(strict_types=1);

namespace RfcTool\Entity\Group;

class Repository extends \Doctrine\ORM\EntityRepository
{
    use \RfcTool\Entity\Share\Timestampable;
    use \RfcTool\Entity\Share\Blameable;

    public function create(\RfcTool\Entity\Group $entity): static
    {
        $this
            ->onCreateTS(model: $entity)
            ->onCreate(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function update(\RfcTool\Entity\Group $entity): static
    {
        $this
            ->onUpdate(model: $entity)
            ->onUpdateTS(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function delete(\RfcTool\Entity\Group $entity): static
    {
        $this
            ->getEntityManager()
            ->remove(object: $entity)
        ;

        return $this;
    }
}
