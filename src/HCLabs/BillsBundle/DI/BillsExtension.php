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
        $loader->load('services/event.xml');
    }

    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        if (true === isset($bundles['TwigBundle'])) {
            $this->configureTwigPaths($container);
            $this->configureTwigFormTemplates($container);
        }
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

    /**
     * @param ContainerBuilder $container
     */
    private function configureTwigPaths(ContainerBuilder $container)
    {
        $container->prependExtensionConfig(
            'twig', [
                'paths' => [
                    '%kernel.root_dir%/../src/HCLabs/Bills/src/Views' => 'HCLabsBills'
                ]
            ]
        );
    }

    /**
     * @param ContainerBuilder $container
     */
    private function configureTwigFormTemplates(ContainerBuilder $container)
    {
        $container->prependExtensionConfig(
            'twig', [
                'form' => [
                    'resources' => [
                        'form_div_layout.html.twig',
                        '@HCLabsBills/Form/Type/money_type.html.twig'
                    ]
                ]
            ]
        );
    }
}