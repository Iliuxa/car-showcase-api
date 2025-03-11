<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Model",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "Внедорожник")
    ]
)]
#[ORM\Entity]
#[ORM\Table(name: 'MODEL')]
class Model extends DictionaryEntity
{
}