<?php

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity]
#[ORM\Table(name: 'your_entity_name')]
class YourEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[Gedmo\Blameable(on: 'create')]
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $createdBy = null;

    #[Gedmo\Blameable(on: 'update')]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $updatedBy = null;

    // Getters and setters for all properties

    public function getId(): ?int
    {
        return $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }
}