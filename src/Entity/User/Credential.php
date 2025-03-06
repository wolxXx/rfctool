<?php

declare(strict_types=1);

namespace RfcTool\Entity\User;


#[\Doctrine\ORM\Mapping\Entity(
    repositoryClass: Credential\Repository::class
)]
#[\Doctrine\ORM\Mapping\Table(
    name   : self::TABLE_NAME,
    options: \RfcTool\Entity\Share\BaseTable::DEFAULT_OPTIONS,
)]
class Credential
{
    use \RfcTool\Entity\Share\Id;
    use \RfcTool\Entity\Share\Repository;

    public const string TABLE_NAME = 'user_credential';


    #[\Doctrine\ORM\Mapping\Column(
        type  : \Doctrine\DBAL\Types\Types::STRING,
        length: 255
    )]
    protected string     $name;

    #[\Doctrine\ORM\Mapping\Column(
        type  : \Doctrine\DBAL\Types\Types::STRING,
        length: 255
    )]
    protected string     $type;

    #[\Doctrine\ORM\Mapping\Column(
        type  : \Doctrine\DBAL\Types\Types::TEXT,
        length: 255,
        nullable: true
    )]
    protected ?string     $note = null;


    #[\Doctrine\ORM\Mapping\ManyToOne(
        targetEntity: \RfcTool\Entity\User::class,
    )]
    #[\Doctrine\ORM\Mapping\JoinColumn(
        nullable: false,
        onDelete: 'CASCADE',
    )]
    protected \RfcTool\Entity\User $user;

    public function __construct() {
    }


    public static function getRepository(): Group\Repository
    {
        return static::getRepositoryByClassName();
    }

}