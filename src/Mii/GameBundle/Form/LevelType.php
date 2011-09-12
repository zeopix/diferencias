<?php

namespace Mii\GameBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class LevelType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('block','text')
            ->add('time1','text')
            ->add('time2','text')
            ->add('time3','text')
            ->add('timeout','text')
            ->add('title','text')
            ->add('file')
        ;
    }

    public function getName()
    {
        return 'mii_gamebundle_leveltype';
    }
}
