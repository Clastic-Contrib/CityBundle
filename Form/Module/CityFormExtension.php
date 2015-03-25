<?php

namespace Clastic\CityBundle\Form\Module;

use Clastic\NodeBundle\Form\Extension\AbstractNodeTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * CityTypeExtension
 */
class CityFormExtension extends AbstractNodeTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->getTabHelper($builder)
            ->findTab('general')
            ->add('metroCode')
            ->add('country', 'entity', array(
                'class' => 'ClasticCityBundle:Country',
                'property' => 'node.title',
            ));
    }
}
