<?php

declare(strict_types = 1);

namespace RfcTool\Entity\UserInGroup;

class Repository extends
    \Doctrine\ORM\EntityRepository
{
    use \RfcTool\Entity\Share\Timestampable;
    use \RfcTool\Entity\Share\Blameable;

    public function isMember(\RfcTool\Entity\User $user, \RfcTool\Entity\Group $group, ?\DateTime $now): bool
    {
        $now = $now ?? \Carbon\Carbon::now();

        return null !== $this
                ->createQueryBuilder('user_in_group')
                ->andWhere('user_in_group.user = :user')
                ->andWhere('user_in_group.group = :group')
                ->andWhere('user_in_group.end IS NULL OR user_in_group.end > :now')
                ->andWhere('user_in_group.begin <= :now')
                ->setParameter('user', $user)
                ->setParameter('group', $group)
                ->setParameter('now', $now)
                ->getQuery()
                ->getOneOrNullResult()
        ;
    }

    public function create(\RfcTool\Entity\UserInGroup $entity): static
    {
        $this
            ->onCreateTS(model: $entity)
            ->onCreate(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function update(\RfcTool\Entity\UserInGroup $entity): static
    {
        $this
            ->onUpdate(model: $entity)
            ->onUpdateTS(model: $entity)
            ->getEntityManager()
            ->persist(object: $entity)
        ;

        return $this;
    }

    public function delete(\RfcTool\Entity\UserInGroup $entity): static
    {
        $this
            ->getEntityManager()
            ->remove(object: $entity)
        ;

        return $this;
    }
}
