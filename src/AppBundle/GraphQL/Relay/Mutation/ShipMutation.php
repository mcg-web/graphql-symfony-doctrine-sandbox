<?php

namespace AppBundle\GraphQL\Relay\Mutation;

use AppBundle\Entity\Faction;
use AppBundle\Entity\Ship;
use Overblog\GraphQLBundle\Error\UserError;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ShipMutation implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function createShip($shipName, $factionId)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');

        $faction = $em->find('AppBundle:Faction', $factionId);
        if (!$faction instanceof Faction) {
            throw new UserError(sprintf('Unknown faction with id "%d"', $factionId));
        }

        $ship = new Ship();
        $ship->setName($shipName);

        $faction->addShip($ship);

        $em->persist($ship);
        $em->persist($faction);

        try {
            $em->flush();
        } catch (\Exception $e) {
            throw new UserError(sprintf('Could not save ship with name "%s". Retry later', $shipName));
        }

        return [
            'ship' => $ship,
            'faction' => $faction,
        ];
    }
}
