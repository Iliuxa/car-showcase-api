<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Brand",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "Мерседес")
    ]
)]
#[ORM\Entity]
#[ORM\Table(name: 'BRAND')]
class Brand extends DictionaryEntity
{
}