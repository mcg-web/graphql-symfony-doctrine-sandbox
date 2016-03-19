<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Faction;
use AppBundle\Entity\Ship;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\Mapping\ClassMetadata;

class LoadShipAndFactionData implements FixtureInterface
{
    private $data = [
        'ships' => [
            [
                'id' => '1',
                'name' => 'X-Wing',
            ],
            [
                'id' => '2',
                'name' => 'Y-Wing',
            ],
            [
                'id' => '3',
                'name' => 'A-Wing',
            ],
            [
                'id' => '4',
                'name' => 'Millenium Falcon',
            ],
            [
                'id' => '5',
                'name' => 'Home One',
            ],
            [
                'id' => '6',
                'name' => 'TIE Fighter',
            ],
            [
                'id' => '7',
                'name' => 'TIE Interceptor',
            ],
            [
                'id' => '8',
                'name' => 'Executor',
            ],
        ],
        'factions' => [
            [
                'id' => '1',
                'name' => 'Alliance to Restore the Republic',
                'ships' => ['1', '2', '3', '4', '5'],
                'type' => Faction::TYPE_REBELS,
            ],
            [
                'id' => '2',
                'name' => 'Galactic Empire',
                'type' => Faction::TYPE_EMPIRE,
                'ships' => ['6', '7', '8']
            ]
        ],
    ];

    /** @var Ship[] */
    private $ships = [];

    public function load(ObjectManager $manager)
    {
        $this->loadShips($manager, $this->data['ships']);
        $this->loadFactions($manager, $this->data['factions']);
    }

    private function loadShips(ObjectManager $manager, array $ships)
    {
        foreach($ships as $data) {

            $ship = new Ship();
            $ship->fromArray($data);

            $manager->persist($ship);
            $metadata = $manager->getClassMetaData(get_class($ship));
            $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            $manager->flush();

            $this->ships[$ship->getId()] = $ship;
        }
    }

    private function loadFactions(ObjectManager $manager, array $factions)
    {
        foreach($factions as $data) {
            $ships = $data['ships'];
            unset($data['ships']);
            $faction = new Faction();
            $faction->fromArray($data);
            foreach($ships as $shipId) {
                $faction->addShip($this->ships[$shipId]);
            }
            $manager->persist($faction);
            $metadata = $manager->getClassMetaData(get_class($faction));
            $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
            $manager->flush();
        }
    }
}
