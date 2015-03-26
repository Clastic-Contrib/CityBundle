<?php
/**
 * This file is part of the Clastic Modules package.
 *
 * (c) Dries De Peuter <dries@nousefreak.be>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clastic\CityBundle\Hydrator;

use Clastic\CityBundle\Entity\City;
use Clastic\CityBundle\Entity\CityRepository;
use Clastic\CityBundle\Iterator\CityIteratorInterface;
use Clastic\NodeBundle\Node\NodeManager;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Console\Helper\ProgressBar;

/**
 * @author Dries De Peuter <dries@nousefreak.be>
 */
class Hydrator
{
    /**
     * @var NodeManager
     */
    private $nodeManager;

    /**
     * @var ObjectManager
     */
    private $objectManager;

    /**
     * @param $tmpDir
     */
    public function __construct(NodeManager $nodeManager, ObjectManager $objectManager)
    {
        $this->nodeManager = $nodeManager;
        $this->objectManager = $objectManager;
    }

    /**
     *
     */
    public function hydrate(CityIteratorInterface $iterator, ProgressBar $progress)
    {
        $admin = $this->getAdminUser();

        foreach ($iterator as $index => $cityData) {
            $progress->advance();

            $exists = $this->getCityRepo()
                ->createQueryBuilder('c')
                ->join('ClasticNodeBundle:Node', 'n')
                ->where('n.title = :title AND c.metroCode = :metroCode')
                ->getQuery()
                ->execute(array(
                    'title'     => $cityData['name'],
                    'metroCode' => $cityData['zip'],
                ));

            if (count($exists)) {
                continue;
            }

            /** @var City $city */
            $city = $this->nodeManager->createNode('city');
            $city->getNode()->setTitle($cityData['name']);
            $city->setMetroCode($cityData['zip']);
            $city->setCountry($cityData['country']);
            $city->getNode()->setUser($admin);

            $this->objectManager->persist($city);
            $this->objectManager->flush();
        }
    }

    /**
     * @return CityRepository
     */
    private function getCityRepo()
    {
        return $this->objectManager->getRepository('ClasticCityBundle:City');
    }

    private function getAdminUser()
    {
        $admin = $this->objectManager->getRepository('ClasticUserBundle:User')->findBy(array(), array(
            'id' => 'desc',
        ), 1);

        return reset($admin);
    }
}
