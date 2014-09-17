<?php

namespace HCLabs\BillsBundle\Configuration;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class CommandBusCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $bus = $container->getDefinition('hclabs_bills.command.command_bus');

        $handlers = $container->findTaggedServiceIds('command.handler');

        foreach ($handlers as $id => $tag) {
            foreach ($tag as $tagAttributes) {
                $bus->addMethodCall('addHandler', [new Reference($id), $tagAttributes['handles']]);
            }
        }
    }

}