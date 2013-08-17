<?php
namespace SmartCore\Bundle\BlogBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TagFormType extends AbstractType
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
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->class,
        ));
    }

    public function getName()
    {
        return 'smart_blog_tag';
    }

    public function getDefaultOptions(array $options)
    {
        return array(
            'data_class'      => 'SmartCore\Bundle\BlogBundle\Form\Type\TagFormType',
            'csrf_protection' => false,
//            'csrf_field_name' => '_token',
            // уникальный ключ для генерации секретного токена
//           'intention'       => 'tag_item',
        );
    }
}
