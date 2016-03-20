<?php

namespace AppBundle\GraphQL\Relay\Resolver;

use AppBundle\Entity\Faction;
use AppBundle\Entity\Repository\ShipRepository;
use Overblog\GraphQLBundle\Relay\Connection\Output\ConnectionBuilder;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class FactionResolver implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function resolveRebels()
    {
        $rebels = $this->getFactionByType(Faction::TYPE_REBELS);

        return $rebels;
    }

    public function resolveEmpire()
    {
        $empire = $this->getFactionByType(Faction::TYPE_EMPIRE);

        return $empire;
    }

    public function resolveShips(Faction $faction, $args)
    {
//        $ships = $faction->getShips()->toArray();
//        $connection = ConnectionBuilder::connectionFromArray($ships, $args);
//        $connection->sliceSize = count($connection->edges);
//
//        return $connection;

        /** @var ShipRepository $repository */
        $repository = $this->container
            ->get('doctrine.orm.default_entity_manager')
            ->getRepository('AppBundle:Ship');

        $arrayLength = $repository->countAllByFactionId($faction->getId());
        $beforeOffset = ConnectionBuilder::getOffsetWithDefault($args['before'], $arrayLength);
        $afterOffset = ConnectionBuilder::getOffsetWithDefault($args['after'], -1);

        $startOffset = max($afterOffset, -1) + 1;
        $endOffset = min($beforeOffset, $arrayLength);

        if (is_numeric($args['first'])) {
            $endOffset = min($endOffset, $startOffset + $args['first']);
        }
        if (is_numeric($args['last'])) {
            $startOffset = max($startOffset, $endOffset - $args['last']);
        }
        $offset = max($startOffset, 0);
        $limit = $endOffset - $startOffset;

        $ships = $repository->retrieveShipsByFactionId($faction->getId(), $offset, $limit);
        
        $connection = ConnectionBuilder::connectionFromArraySlice(
            $ships,
            $args,
            [
                'sliceStart' => $offset,
                'arrayLength' => $arrayLength,
            ]
        );
        $connection->sliceSize = count($ships);

        return $connection;
    }

    private function getFactionByType($type)
    {
        return $this->container->get('doctrine.orm.default_entity_manager')
            ->getRepository('AppBundle:Faction')->findOneBy(['type' => $type]);
    }
}
