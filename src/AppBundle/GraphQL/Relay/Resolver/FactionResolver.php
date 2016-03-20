<?php

namespace AppBundle\GraphQL\Relay\Resolver;

use AppBundle\Entity\Faction;
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
        return ConnectionBuilder::connectionFromArray($faction->getShips()->toArray(), $args);
    }

    private function getFactionByType($type)
    {
        return $this->container->get('doctrine.orm.default_entity_manager')
            ->getRepository('AppBundle:Faction')->findOneBy(['type' => $type]);
    }
}
