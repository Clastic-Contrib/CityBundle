<?php

namespace Clastic\CityBundle\Entity;

use Clastic\NodeBundle\Node\NodeReferenceInterface;
use Clastic\NodeBundle\Node\NodeReferenceTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Continent
 */
class Continent implements NodeReferenceInterface
{
    use NodeReferenceTrait;

    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $code;


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
     * Set code
     *
     * @param string $code
     * @return Continent
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string 
     */
    public function getCode()
    {
        return $this->code;
    }
}
