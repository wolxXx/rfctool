<?php

declare(strict_types = 1);

namespace RfcTool\Service\User\Creator;

final class CredentialList implements
    \VersatileCollections\StrictlyTypedCollectionInterface
{
    use \VersatileCollections\StrictlyTypedCollectionInterfaceImplementationTrait;

    public function __construct(CredentialBag ...$bags)
    {
        $this->versatile_collections_items = $bags;
    }

    public function checkType(mixed $item): bool
    {
        return true === $item instanceof CredentialBag;
    }

    public function getTypes(): \VersatileCollections\StringsCollection
    {
        return new \VersatileCollections\StringsCollection(CredentialBag::class);
    }
}