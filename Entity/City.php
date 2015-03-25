<?php

namespace Clastic\CityBundle\Entity;

use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Clastic\NodeBundle\Node\NodeReferenceTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * City
 */
class City implements NodeReferenceInterface
{
    use NodeReferenceTrait;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $metroCode;

    /**
     * @var Country
     */
    private $country;

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
     * Set metroCode
     *
     * @param string $metroCode
     * @return City
     */
    public function setMetroCode($metroCode)
    {
        $this->metroCode = $metroCode;

        return $this;
    }

    /**
     * Get metroCode
     *
     * @return string 
     */
    public function getMetroCode()
    {
        return $this->metroCode;
    }

    /**
     * @return Country
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param Country $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
}
