<?php

namespace SmartCore\Bundle\TexterBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class TexterEditFormType extends TexterFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('save', 'submit', [
            'attr' => [
                'class' => 'btn btn-primary',
            ],
        ]);
    }

    public function getName()
    {
        return 'smart_texter_update';
    }
}
