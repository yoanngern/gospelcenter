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
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
            new SunCat\MobileDetectBundle\MobileDetectBundle(),
            new JMS\AopBundle\JMSAopBundle(),
            new JMS\SecurityExtraBundle\JMSSecurityExtraBundle(),
            new JMS\DiExtraBundle\JMSDiExtraBundle($this),
            new JMS\I18nRoutingBundle\JMSI18nRoutingBundle(),
            new JMS\TranslationBundle\JMSTranslationBundle(),
            new FOS\UserBundle\FOSUserBundle(),
            new Liip\ImagineBundle\LiipImagineBundle(),
            new gospelcenter\EventBundle\gospelcenterEventBundle(),
            new gospelcenter\CenterBundle\gospelcenterCenterBundle(),
            new gospelcenter\PageBundle\gospelcenterPageBundle(),
            new gospelcenter\ImageBundle\gospelcenterImageBundle(),
            new gospelcenter\LocationBundle\gospelcenterLocationBundle(),
            new gospelcenter\AdminBundle\gospelcenterAdminBundle(),
            new gospelcenter\CelebrationBundle\gospelcenterCelebrationBundle(),
            new gospelcenter\MediaBundle\gospelcenterMediaBundle(),
            new gospelcenter\PeopleBundle\gospelcenterPeopleBundle(),
            new gospelcenter\LanguageBundle\gospelcenterLanguageBundle(),
            new gospelcenter\ArticleBundle\gospelcenterArticleBundle(),
            new gospelcenter\APIBundle\gospelcenterAPIBundle(),
            new gospelcenter\UserBundle\gospelcenterUserBundle(),
            new gospelcenter\AccessBundle\gospelcenterAccessBundle(),
            new gospelcenter\DateBundle\gospelcenterDateBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
            $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
            $bundles[] = new CoreSphere\ConsoleBundle\CoreSphereConsoleBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
    }
}
