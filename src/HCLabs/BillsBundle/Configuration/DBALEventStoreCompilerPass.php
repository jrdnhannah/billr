<?php

namespace HCLabs\BillsBundle\Configuration;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class DBALEventStoreCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $dbalCommand = $container->getDefinition('hclabs_bills.console.create_dbal_event_store');

        $dbalBuilders = $container->findTaggedServiceIds('event_sourcing.dbal_schema_builder');

        $arguments = $dbalCommand->getArguments();

        $builders = is_array($arguments[1]) ? $arguments[1] : [];

        foreach ($dbalBuilders as $id => $tags) {
            $builders[] = new Reference($id);
        }

        $dbalCommand->setArguments([
                $arguments[0],
                $builders,
                $arguments[2]
            ]
        );
    }

}