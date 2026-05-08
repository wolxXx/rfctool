<?php

declare(strict_types = 1);

namespace RfcTool\Entity\UserInGroup;

class Repository extends
    \Doctrine\ORM\EntityRepository
{
    use \RfcTool\Entity\Share\Timestampable;
    use \RfcTool\Entity\Share\Blameable;

    /**
     * @return \RfcTool\Entity\UserInGroup[]
     */
    public function getForUser(\RfcTool\Entity\User $user): array
    {
        return $this
            ->createQueryBuilder('user_in_group')
            ->andWhere('user_in_group.user = :user')
            ->setParameter('user', $user)
            ->orderBy('user_in_group.user', 'ASC')
            ->addOrderBy('user_in_group.beginDate', 'DESC')
            ->getQuery()
            ->execute()
        ;
    }

    /**
     * @return \RfcTool\Entity\UserInGroup[]
     */
    public function getForGroup(\RfcTool\Entity\Group $group): array
    {
        return $this
            ->createQueryBuilder(alias: 'user_in_group')
            ->setCacheable(cacheable: false)
            ->andWhere('user_in_group.group = :group')
            ->setParameter(key: 'group', value: $group)
            ->orderBy(sort: 'user_in_group.user', order: 'ASC')
            ->addOrderBy(sort: 'user_in_group.beginDate', order: 'DESC')
            ->getQuery()
            ->execute()
        ;
    }

    public function isMember(\RfcTool\Entity\User $user, \RfcTool\Entity\Group $group, ?\DateTime $now): bool
    {
        $now = $now ?? \Carbon\Carbon::now();

        return null !== $this
                ->createQueryBuilder('user_in_group')
                ->andWhere('user_in_group.user = :user')
                ->andWhere('user_in_group.group = :group')
                ->andWhere('user_in_group.endDate IS NULL OR user_in_group.endDate > :now')
                ->andWhere('user_in_group.beginDate <= :now')
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
