<?php

namespace Clastic\CityBundle\Form\Module;

use Clastic\NodeBundle\Form\Extension\AbstractNodeTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * ContinentTypeExtension
 */
class ContinentFormExtension extends AbstractNodeTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->getTabHelper($builder)
            ->findTab('general')
            ->add('code');
    }
}
