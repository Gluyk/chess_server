<?php

namespace App\Controller;

use OpenApi\Attributes\Property;

class Step
{
    #[Property(example: 'a1')]
    public string $step;
}