<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Faction.
 */
class Faction
{
    use FromArrayTrait;

    const TYPE_REBELS = 'Rebels';
    const TYPE_EMPIRE = 'Empire';

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
    private $ships;

    /**
     * @var string
     */
    private $type;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->ships = new ArrayCollection();
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
     * @return Faction
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
     * Add ship.
     *
     * @param Ship $ship
     *
     * @return Faction
     */
    public function addShip(Ship $ship)
    {
        $this->ships[] = $ship;

        return $this;
    }

    /**
     * Remove ship.
     *
     * @param Ship $ship
     */
    public function removeShip(Ship $ship)
    {
        $this->ships->removeElement($ship);
    }

    /**
     * Get ships.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShips()
    {
        return $this->ships;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return Faction
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
