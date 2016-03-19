<?php

namespace AppBundle\Entity;

trait FromArrayTrait
{
    public function fromArray(array $data)
    {
        foreach($data as $property => $value) {
            $this->$property = $value;
        }
    }
}
