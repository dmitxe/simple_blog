<?php
namespace SmartCore\Bundle\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleFormType extends AbstractType
{
    protected $class;

    /**
     * @param string $class
     */
    public function __construct($class)
    {
        $this->class = $class;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('slug')
            ->add('annotation')
            ->add('text')
            ->add('description')
            ->add('keywords')
        ;

        if (array_key_exists('SmartCore\Bundle\BlogBundle\Model\CategoryTrait', class_uses($this->class, false))) {
            $builder->add('category'); // @todo сделать отображение вложенных категорий.
        }

        if (array_key_exists('SmartCore\Bundle\BlogBundle\Model\TagTrait', class_uses($this->class, false))) {
            $builder->add('tags', null, ['expanded' => true]);
        }
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
        ));
    }

    public function getName()
    {
        return 'smart_blog_article';
    }
}
