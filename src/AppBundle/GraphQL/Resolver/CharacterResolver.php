<?php

namespace AppBundle\GraphQL\Resolver;

require_once __DIR__ . '/../../../../vendor/webonyx/graphql-php/tests/StarWarsData.php';

use AppBundle\Entity\Character;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use GraphQL\StarWarsData;

class CharacterResolver implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function resolveType(Character $character = null)
    {
        if (null === $character) {
            return null;
        }

        $typeResolver = $this->container->get('overblog_graphql.type_resolver');
        return $typeResolver->resolve($character->getType());
    }

    public function resolveHero($args)
    {
        return StarWarsData::getHero(isset($args['episode']) ? $args['episode'] : null);
    }

    public function resolveHuman($args)
    {
        return $this->resolveCharacter($args['id'], Character::TYPE_HUMAN);
    }

    public function resolveDroid($args)
    {
        return $this->resolveCharacter($args['id'], Character::TYPE_DROID);
    }

    private function resolveCharacter($id, $type)
    {
        $character = $this->getCharacter($id);
        if (null === $character) {
            return;
        }
        return $type === $character->getType() ? $character : null;
    }

    /**
     * @param $id
     * @return Character|null
     */
    private function getCharacter($id)
    {
        return $this->container->get('doctrine.orm.default_entity_manager')
            ->find('AppBundle:Character', (int)$id);
    }
}
