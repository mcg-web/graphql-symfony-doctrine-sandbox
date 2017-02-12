<?php

namespace AppBundle\GraphQL\Loader;

use AppBundle\Entity\Repository\ShipRepository;
use GraphQL\Executor\Promise\PromiseAdapter;

class ShipLoader
{
    private $promiseAdapter;

    private $repository;

    public function __construct(PromiseAdapter $promiseAdapter, ShipRepository $repository)
    {
        $this->promiseAdapter = $promiseAdapter;
        $this->repository = $repository;
    }

    public function all(array $shipsIDs)
    {
        $ships = $this->repository->findBy(['id' => $shipsIDs]);

        return $this->promiseAdapter->all($ships);
    }
}
