<?php

namespace Clastic\CityBundle\Module;

use Clastic\CoreBundle\Module\SubmoduleInterface;
use Clastic\NodeBundle\Module\NodeModuleInterface;

/**
 * Continent
 */
class ContinentModule implements NodeModuleInterface, SubmoduleInterface
{
    /**
     * The name of the module.
     *
     * @return string
     */
    public function getName()
    {
        return 'Continent';
    }

    /**
     * The name of the module.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return 'continent';
    }

    /**
     * The identifier of the parent module.
     *
     * @return string
     */
    public function getParentIdentifier()
    {
        return 'city';
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return 'ClasticCityBundle:Continent';
    }

    /**
     * @return string|bool
     */
    public function getDetailTemplate()
    {
        return 'ClasticCityBundle:Continent:detail.html.twig';
    }
}
