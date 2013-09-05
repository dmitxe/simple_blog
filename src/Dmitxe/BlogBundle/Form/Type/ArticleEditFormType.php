<?php

namespace Dmitxe\BlogBundle\Form\Type;

use SmartCore\Bundle\BlogBundle\Form\Type\ArticleEditFormType as BaseArticleEditFormType;
use Symfony\Component\Form\FormBuilderInterface;

class ArticleEditFormType extends BaseArticleEditFormType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('image');

        parent::buildForm($builder, $options);
    }
}
