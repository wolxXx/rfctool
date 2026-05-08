<?php

declare(strict_types = 1);

namespace RfcTool\Entity\Proposal\Vote;

class Repository extends
    \Doctrine\ORM\EntityRepository
{
    use \RfcTool\Entity\Share\Timestampable;
    use \RfcTool\Entity\Share\Blameable;


    public function findForUserAndProposal(\RfcTool\Entity\User $user, \RfcTool\Entity\Proposal $proposal): ?\RfcTool\Entity\Proposal\Vote
    {
        return $this->findOneBy([
                                    'user'     => $user,
                                    'proposal' => $proposal,
                                ]);
    }

    public function create(\RfcTool\Entity\Proposal\Vote $entity): static
    {
        $this
            ->onCreateTS(model: $entity)
            ->onCreate(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function update(\RfcTool\Entity\Proposal\Vote $entity): static
    {
        $this
            ->onUpdate(model: $entity)
            ->onUpdateTS(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function delete(\RfcTool\Entity\Proposal\Vote $entity): static
    {
        $this
            ->getEntityManager()
            ->remove(object: $entity)
        ;

        return $this;
    }
}
