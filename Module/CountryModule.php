<?php

namespace Clastic\CityBundle\Module;

use Clastic\CoreBundle\Module\SubmoduleInterface;
use Clastic\NodeBundle\Module\NodeModuleInterface;

/**
 * Country
 */
class CountryModule implements NodeModuleInterface, SubmoduleInterface
{
    /**
     * The name of the module.
     *
     * @return string
     */
    public function getName()
    {
        return 'Country';
    }

    /**
     * The name of the module.
     *
     * @return string
     */
    public function getIdentifier()
    {
        return 'country';
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
        return 'ClasticCityBundle:Country';
    }

    /**
     * @return string|bool
     */
    public function getDetailTemplate()
    {
        return 'ClasticCityBundle:Country:detail.html.twig';
    }
}
