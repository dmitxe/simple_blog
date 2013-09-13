<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

// @todo убрать отсюда.
require_once __DIR__.'/../src/SmartCore/Bundle/SimpleProfilerBundle/Profiler.php';

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            //new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(), "sensio/framework-extra-bundle": "2.2.*",
            //new JMS\AopBundle\JMSAopBundle(),
            //new JMS\DiExtraBundle\JMSDiExtraBundle($this), "jms/di-extra-bundle": "1.3.*"
            //new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(), "jms/security-extra-bundle": "1.4.*",
            new Avalanche\Bundle\ImagineBundle\AvalancheImagineBundle(),
            new Exercise\HTMLPurifierBundle\ExerciseHTMLPurifierBundle(),
            new FM\BbcodeBundle\FMBbcodeBundle(),
            new FM\ElfinderBundle\FMElfinderBundle(),
            new FOS\CommentBundle\FOSCommentBundle(),
            new FOS\RestBundle\FOSRestBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Genemu\Bundle\FormBundle\GenemuFormBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle($this),
            new Knp\Bundle\DisqusBundle\KnpDisqusBundle(),
            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Liip\DoctrineCacheBundle\LiipDoctrineCacheBundle(),
            new Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(),
            new Mremi\ContactBundle\MremiContactBundle(),
            new Ornicar\AkismetBundle\OrnicarAkismetBundle(),
            new Ornicar\GravatarBundle\OrnicarGravatarBundle(),
            new RaulFraile\Bundle\LadybugBundle\RaulFraileLadybugBundle(),
            new SmartCore\Bundle\BlogBundle\SmartBlogBundle(),
            new SmartCore\Bundle\GalleryBundle\SmartGalleryBundle(),
            new SmartCore\Bundle\HtmlBundle\HtmlBundle(),
            new SmartCore\Bundle\MediaBundle\SmartMediaBundle(),
            new SmartCore\Bundle\SimpleProfilerBundle\SmartSimpleProfilerBundle(),
            new SmartCore\Bundle\SitemapBundle\SmartSitemapBundle(),
            new SmartCore\Bundle\SocialBundle\SmartSocialBundle(),
            new SmartCore\Bundle\TexterBundle\SmartTexterBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),
            new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            //new Vich\UploaderBundle\VichUploaderBundle(), // "vich/uploader-bundle": "dev-master",

            new Dmitxe\CommentBundle\DmitxeCommentBundle(),
            new Dmitxe\ContactBundle\DmitxeContactBundle(),
            new Dmitxe\BlogBundle\DmitxeBlogBundle(),
            new Dmitxe\DemoBundle\DmitxeDemoBundle(),
            new Dmitxe\FixturesBundle\DmitxeFixturesBundle(),
            new Dmitxe\GalleryBundle\DmitxeGalleryBundle(),
            new Dmitxe\NewsBundle\DmitxeNewsBundle(),
            new Dmitxe\SiteBundle\DmitxeSiteBundle(),
            new Dmitxe\UserBundle\DmitxeUserBundle(),
        );

        if (in_array($this->getEnvironment(), ['dev'])) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            $bundles[] = new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle();
            $bundles[] = new Elao\WebProfilerExtraBundle\WebProfilerExtraBundle();
            $bundles[] = new JMS\DebuggingBundle\JMSDebuggingBundle($this); //"jms/debugging-bundle": "dev-master",
        }

        if (in_array($this->getEnvironment(), ['test'])) {
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            $bundles[] = new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }

    protected function getContainerBaseClass()
    {
        if (in_array($this->getEnvironment(), ['dev'])) {
            return '\JMS\DebuggingBundle\DependencyInjection\TraceableContainer';
        }

        return parent::getContainerBaseClass();
    }

    public function getCacheDir()
    {
        return $this->rootDir.'/../var/cache/'.$this->environment;
    }

    public function getLogDir()
    {
        return $this->rootDir.'/../var/logs';
    }
}
