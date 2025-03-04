<?php

declare(strict_types=1);

namespace RfcTool\Entity\Share;

trait Repository
{
    protected static function getRepositoryByClassName(): \Doctrine\ORM\EntityRepository
    {
        return \RfcTool\Util\DependencyContainer::getInstance()
                                                   ->getEntityManager()
                                                   ->getRepository(className: __CLASS__)
        ;
    }
}
