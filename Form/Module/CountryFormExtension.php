<?php

namespace Clastic\CityBundle\Form\Module;

use Clastic\NodeBundle\Form\Extension\AbstractNodeTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * CountryTypeExtension
 */
class CountryFormExtension extends AbstractNodeTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->getTabHelper($builder)
            ->findTab('general')
            ->add('iso')
            ->add('continent', 'entity', array(
                'class' => 'ClasticCityBundle:Continent',
                'property' => 'node.title',
            ));
    }
}
