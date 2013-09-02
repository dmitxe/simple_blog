<?php

namespace Dmitxe\ContactBundle\Form\Type;

use Mremi\ContactBundle\Model\Contact;
use Mremi\ContactBundle\Provider\NoopSubjectProvider;
use Mremi\ContactBundle\Provider\SubjectProviderInterface;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Contact type class
 *
 * @author Rémi Marseille <marseille.remi@gmail.com>
 */
class ContactType extends AbstractType
{
    const TRANSLATION_DOMAIN = 'MremiContactBundle';

    /**
     * @var SubjectProviderInterface
     */
    private $subjectProvider;

    /**
     * @var string
     */
    private $class;

    /**
     * @var boolean
     */
    private $captchaDisabled;

    /**
     * @var string
     */
    private $captchaType;

    /**
     * Constructor
     *
     * @param SubjectProviderInterface $subjectProvider A subject provider instance
     * @param boolean                  $captchaDisabled TRUE whether you want disable the captcha
     * @param string                   $captchaType     The captcha type
     */
    public function __construct(SubjectProviderInterface $subjectProvider = null, $captchaDisabled = false, $captchaType = 'genemu_captcha')
    {
        $this->subjectProvider = (null === $subjectProvider)
            ? new NoopSubjectProvider()
            : $subjectProvider;

        $this->class           = 'Dmitxe\ContactBundle\Entity\Contact';
        $this->captchaDisabled = $captchaDisabled;
        $this->captchaType     = $captchaType;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*
        $builder
            ->add('title', 'choice', [
                'choices'            => Contact::getTitles(),
                'expanded'           => true,
                'label'              => 'mremi_contact.form.title',
                'translation_domain' => self::TRANSLATION_DOMAIN,
            ]);
        */
        $builder
            ->add('firstName', 'text',  ['label' => 'mremi_contact.form.first_name', 'translation_domain' => self::TRANSLATION_DOMAIN])
            ->add('lastName',  'text',  ['label' => 'mremi_contact.form.last_name',  'translation_domain' => self::TRANSLATION_DOMAIN])
            ->add('email',     'email', ['label' => 'mremi_contact.form.email',      'translation_domain' => self::TRANSLATION_DOMAIN]);

        if ($subjects = $this->subjectProvider->getSubjects()) {
            $builder->add('subject', 'choice', [
                'choices'            => $subjects,
                'label'              => 'mremi_contact.form.subject',
                'translation_domain' => self::TRANSLATION_DOMAIN,
            ]);
        } else {
            $builder->add('subject', 'text', ['label' => 'mremi_contact.form.subject', 'translation_domain' => self::TRANSLATION_DOMAIN]);
        }

        $builder->add('message', 'textarea', ['label' => 'mremi_contact.form.message', 'translation_domain' => self::TRANSLATION_DOMAIN]);

        if (!$this->captchaDisabled) {
            $builder->add('captcha', $this->captchaType, [
                'label'              => 'mremi_contact.form.captcha',
                'translation_domain' => self::TRANSLATION_DOMAIN,
                'mapped'             => false,
            ]);
        }

        $builder->add('save', 'submit', ['label' => 'mremi_contact.form_submit', 'translation_domain' => self::TRANSLATION_DOMAIN]);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'data_class' => $this->class,
            'intention'  => 'contact',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'mremi_contact';
    }
}
