<?php

namespace HCLabs\BillsBundle\DI;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class BillsExtension extends ConfigurableExtension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    protected function loadInternal(array $mergedConfig, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config/'));
        $loader->load('services.xml');
        $loader->load('services/controllers.xml');
        $loader->load('services/command.xml');
        $loader->load('services/form.xml');
        $loader->load('services/serialization.xml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (false === isset($bundles['TwigBundle'])) {
            return;
        }

        $container->prependExtensionConfig(
            'twig',
            ['paths' => [
                '%kernel.root_dir%/../src/HCLabs/Bills/src/Views' => 'HCLabsBills'
            ]]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getConfiguration(array $config, ContainerBuilder $container)
    {
        return new Configuration($this->getAlias());
    }

    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'bills';
    }
}