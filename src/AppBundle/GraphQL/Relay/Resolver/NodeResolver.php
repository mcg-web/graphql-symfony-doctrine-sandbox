<?php

namespace AppBundle\GraphQL\Relay\Resolver;

use AppBundle\Entity\Faction;
use AppBundle\Entity\Ship;
use Overblog\GraphQLBundle\Relay\Node\GlobalId;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class NodeResolver implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param $globalId
     *
     * @return null|Faction|Ship
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\TransactionRequiredException
     */
    public function resolveNode($globalId)
    {
        $params = GlobalId::fromGlobalId($globalId);

        if (in_array($params['type'], ['Faction', 'Ship'])) {
            return $this->container->get('doctrine.orm.default_entity_manager')
                ->find('AppBundle:'.$params['type'], $params['id']);
        }

        return;
    }

    /**
     * @param $object
     *
     * @return \GraphQL\Type\Definition\Type
     */
    public function resolveType($object)
    {
        $typeResolver = $this->container->get('overblog_graphql.type_resolver');

        return $object instanceof Ship ? $typeResolver->resolve('Ship') : $typeResolver->resolve('Faction');
    }
}
