<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Character
 */
class Character
{
    use FromArrayTrait;

    const TYPE_HUMAN = 'Human';
    const TYPE_DROID = 'Droid';

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $homePlanet;

    /**
     * @var string
     */
    private $type;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $friends;

    /**
     * @var string
     */
    private $primaryFunction;

    /**
     * @var array
     */
    private $appearsIn;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->friends = new ArrayCollection();
    }

    /**
     * Add friend
     *
     * @param Character $friend
     *
     * @return Character
     */
    public function addFriend(Character $friend)
    {
        $this->friends[] = $friend;

        return $this;
    }

    /**
     * Remove friend
     *
     * @param Character $friend
     */
    public function removeFriend(Character $friend)
    {
        $this->friends->removeElement($friend);
    }

    /**
     * Get friends
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFriends()
    {
        return $this->friends;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Character
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set homePlanet
     *
     * @param string $homePlanet
     *
     * @return Character
     */
    public function setHomePlanet($homePlanet)
    {
        $this->homePlanet = $homePlanet;

        return $this;
    }

    /**
     * Get homePlanet
     *
     * @return string
     */
    public function getHomePlanet()
    {
        return $this->homePlanet;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Character
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getPrimaryFunction()
    {
        return $this->primaryFunction;
    }

    /**
     * @param string $primaryFunction
     * @return Character
     */
    public function setPrimaryFunction($primaryFunction)
    {
        $this->primaryFunction = $primaryFunction;
        return $this;
    }

    /**
     * Set appearsIn
     *
     * @param array $appearsIn
     *
     * @return Character
     */
    public function setAppearsIn($appearsIn)
    {
        $this->appearsIn = $appearsIn;

        return $this;
    }

    /**
     * Get appearsIn
     *
     * @return array
     */
    public function getAppearsIn()
    {
        return $this->appearsIn;
    }
}
