<?php

namespace Clastic\CityBundle\Entity;

use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Clastic\NodeBundle\Node\NodeReferenceTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Country
 */
class Country implements NodeReferenceInterface
{
    use NodeReferenceTrait;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $iso;

    /**
     * @var Continent
     */
    private $continent;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set iso
     *
     * @param string $iso
     * @return Country
     */
    public function setIso($iso)
    {
        $this->iso = $iso;

        return $this;
    }

    /**
     * Get iso
     *
     * @return string 
     */
    public function getIso()
    {
        return $this->iso;
    }

    /**
     * @return Continent
     */
    public function getContinent()
    {
        return $this->continent;
    }

    /**
     * @param Continent $continent
     */
    public function setContinent($continent)
    {
        $this->continent = $continent;
    }
}
