<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Ship.
 */
class Ship
{
    use FromArrayTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $factions;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->factions = new ArrayCollection();
    }

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Ship
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add faction.
     *
     * @param Faction $faction
     *
     * @return Ship
     */
    public function addFaction(Faction $faction)
    {
        $this->factions[] = $faction;

        return $this;
    }

    /**
     * Remove faction.
     *
     * @param Faction $faction
     */
    public function removeFaction(Faction $faction)
    {
        $this->factions->removeElement($faction);
    }

    /**
     * Get factions.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFactions()
    {
        return $this->factions;
    }
}
