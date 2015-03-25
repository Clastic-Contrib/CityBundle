<?php

namespace Clastic\CityBundle\Module;

use Clastic\NodeBundle\Module\NodeModuleInterface;

/**
 * City
 */
class CityModule implements NodeModuleInterface
{
    /**
     * The name of the module.
     *
     * @return string
     */
    public function getName()
    {
        return 'City';
    }

    /**
     * The name of the module.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return 'city';
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return 'ClasticCityBundle:City';
    }

    /**
     * @return string|bool
     */
    public function getDetailTemplate()
    {
        return 'ClasticCityBundle:City:detail.html.twig';
    }
}
