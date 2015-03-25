<?php

namespace Clastic\CityBundle\Entity;

use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Clastic\NodeBundle\Node\NodeReferenceTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Divisor
 */
class Divisor implements NodeReferenceInterface
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
     * @return Divisor
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
}
