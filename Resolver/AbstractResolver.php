<?php
/**
 * This file is part of the Clastic Modules package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\CityBundle\Resolver;

use Clastic\CityBundle\Entity\Country;
use Clastic\CityBundle\Entity\CountryRepository;
use Clastic\CityBundle\Iterator\CityIteratorInterface;
use Clastic\NodeBundle\Node\NodeManager;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
abstract class AbstractResolver implements CityIteratorInterface
{
    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var int
     */
    private $position;

    /**
     * @var NodeManager
     */
    private $nodeManager;

    /**
     * @param NodeManager $nodeManager
     * @param ObjectManager $objectManager
     */
    public function __construct(NodeManager $nodeManager, ObjectManager $objectManager)
    {
        $this->nodeManager = $nodeManager;
        $this->objectManager = $objectManager;
        $this->data = array();
        $this->position = 0;

        $this->init();
    }

    abstract protected function init();

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->data[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->data[$this->position]);
    }

    /**
     * @return CountryRepository
     */
    protected function getCountryRepo()
    {
        return $this->objectManager->getRepository('ClasticCityBundle:Country');
    }

    /**
     * @return NodeManager
     */
    protected function getNodeManager()
    {
        return $this->nodeManager;
    }

    protected function getCountry($name, $iso)
    {
        $country = $this->getCountryRepo()
            ->createQueryBuilder('c')
            ->join('ClasticNodeBundle:Node', 'n')
            ->where('n.title = :title')
            ->getQuery()
            ->execute(array(
                'title' => 'Belgium',
            ));

        if (count($country)) {
            return $country[0];
        }

        /** @var Country $country */
        $country = $this->getNodeManager()->createNode('country');
        $country->getNode()->setTitle($name);
        $country->setIso($iso);
        if (isset($country->getNode()->alias)) {
            $country->getNode()->alias->setAlias($name);
        }

        $this->objectManager->persist($country);
        $this->objectManager->flush();

        return $country;
    }
}
