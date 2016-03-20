<?php

namespace AppBundle\DataFixtures\ORM;

require_once __DIR__.'/../../../../vendor/webonyx/graphql-php/tests/StarWarsData.php';

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Character;
use Doctrine\ORM\Mapping\ClassMetadata;
use GraphQL\StarWarsData;

class LoadCharacterData implements FixtureInterface
{
    /** @var Character[] */
    private $characters = [];

    public function load(ObjectManager $manager)
    {
        $this->loadCharacters($manager, StarWarsData::humans(), Character::TYPE_HUMAN);
        $this->loadCharacters($manager, StarWarsData::droids(), Character::TYPE_DROID);
        $this->loadFriends($manager, array_merge(StarWarsData::humans(), StarWarsData::droids()));
    }

    private function loadCharacters(ObjectManager $manager, array $characters, $type)
    {
        foreach ($characters as $data) {
            unset($data['friends']);
            $data['type'] = $type;

            $character = new Character();
            $character->fromArray($data);

            $manager->persist($character);
            $metadata = $manager->getClassMetaData(get_class($character));
            $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            $manager->flush();

            $this->characters[$character->getId()] = $character;
        }
    }

    private function loadFriends(ObjectManager $manager, array $characters)
    {
        foreach ($characters as $data) {
            $character = $this->characters[$data['id']];
            foreach ($data['friends'] as $friendId) {
                $friend = $this->characters[$friendId];
                $character->addFriend($friend);
            }
            $manager->persist($character);
            $manager->flush();
        }
    }
}
