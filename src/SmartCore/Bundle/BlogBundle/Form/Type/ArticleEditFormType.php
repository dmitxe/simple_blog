<?php

namespace SmartCore\Bundle\BlogBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;

class ArticleEditFormType extends ArticleFormType
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
        return 'smart_blog_article_edit';
    }
}
