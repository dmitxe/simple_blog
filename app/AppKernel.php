<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

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
            new RaulFraile\Bundle\LadybugBundle\RaulFraileLadybugBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Mopa\Bundle\BootstrapBundle\MopaBootstrapBundle(),
            new Knp\Bundle\GaufretteBundle\KnpGaufretteBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            new Ornicar\GravatarBundle\OrnicarGravatarBundle(),
            new Avalanche\Bundle\ImagineBundle\AvalancheImagineBundle(),
            new Vich\UploaderBundle\VichUploaderBundle(),
            new Sonata\IntlBundle\SonataIntlBundle(),
            new WhiteOctober\PagerfantaBundle\WhiteOctoberPagerfantaBundle(),
            new Stfalcon\Bundle\TinymceBundle\StfalconTinymceBundle(),
            new FM\ElfinderBundle\FMElfinderBundle(),
            new SmartCore\Bundle\HtmlBundle\HtmlBundle(),
            new SmartCore\Bundle\BlogBundle\SmartBlogBundle(),
            new Dmitxe\SiteBundle\DmitxeSiteBundle(),
            new Dmitxe\UserBundle\DmitxeUserBundle(),
            new Dmitxe\BlogBundle\DmitxeBlogBundle(),
            new Dmitxe\FixturesBundle\DmitxeFixturesBundle(),
            new SmartCore\Bundle\MediaBundle\SmartMediaBundle(),
            new Dmitxe\DemoBundle\DmitxeDemoBundle(),
            new Dmitxe\NewsBundle\DmitxeNewsBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            $bundles[] = new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle();
            $bundles[] = new Elao\WebProfilerExtraBundle\WebProfilerExtraBundle();
            $bundles[] = new JMS\DebuggingBundle\JMSDebuggingBundle($this); //"jms/debugging-bundle": "dev-master",
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }

    protected function getContainerBaseClass()
    {
        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
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

