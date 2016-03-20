<?php

namespace AppBundle\Entity;

use Overblog\GraphQLBundle\Resolver\Resolver;

trait FromArrayTrait
{
    public function fromArray(array $data)
    {
        foreach ($data as $property => $value) {
            Resolver::setObjectOrArrayValue($this, $property, $value);
        }
    }
}
