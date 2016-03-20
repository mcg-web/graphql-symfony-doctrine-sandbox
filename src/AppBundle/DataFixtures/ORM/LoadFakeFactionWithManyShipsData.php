<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Faction;
use AppBundle\Entity\Ship;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;

class LoadFakeFactionWithManyShipsData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faction = $this->loadFaction($manager);
        $this->loadShips($manager, $faction);
    }

    private function loadShips(ObjectManager $manager, Faction $faction)
    {
        for ($i = 0; $i < 1000; ++$i) {
            $ship = new Ship();
            $ship->setId(9 + $i);
            $ship->setName('Fake ship '.$i);
            $faction->addShip($ship);

            $manager->persist($faction);
            $manager->persist($ship);
            $metadata = $manager->getClassMetaData(get_class($ship));
            $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            $manager->flush();
        }
    }

    private function loadFaction(ObjectManager $manager)
    {
        $faction = new Faction();
        $faction->fromArray([
            'id' => '3',
            'name' => 'Fake Faction',
            'type' => Faction::TYPE_FAKE,
        ]);
        $manager->persist($faction);
        $metadata = $manager->getClassMetaData(get_class($faction));
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        $manager->flush();

        return $faction;
    }
}
