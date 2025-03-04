<?php

declare(strict_types=1);

namespace RfcTool\Entity\Session;

class Repository extends \Doctrine\ORM\EntityRepository
{
    use \RfcTool\Entity\Share\Timestampable;
    use \RfcTool\Entity\Share\Blameable;

    public function findOneByName(string $name): ?\RfcTool\Entity\Session
    {
        return $this->findOneBy(criteria: ['name' => $name]);
    }

    public function garbageCollection(int $maxLifeTime): static
    {
        $sub = \DateInterval::createFromDateString(datetime: $maxLifeTime . ' Seconds');
        $max = new \DateTime()
            ->sub(interval: $sub)
            ->format(format: 'Y-m-d H:i:s')
        ;
        $this
            ->createQueryBuilder(alias: 's')
            ->delete(delete: \RfcTool\Entity\Session::class, alias: 's')
            ->andWhere('s.expires < :max')
            ->setParameter(key: 'max', value: $max)
            ->getQuery()
            ->execute()
        ;

        return $this;
    }
}
