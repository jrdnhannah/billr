<?php

namespace HCLabs\BillsBundle;

use Doctrine\Bundle\DoctrineBundle\DependencyInjection\Compiler\DoctrineOrmMappingsPass;
use HCLabs\BillsBundle\Configuration\CommandBusCompilerPass;
use HCLabs\BillsBundle\Configuration\DBALEventStoreCompilerPass;
use HCLabs\BillsBundle\DI\BillsExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class HCLabsBillsBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass($this->buildMappingCompilerPass());
        $container->addCompilerPass(new CommandBusCompilerPass);
        $container->addCompilerPass(new DBALEventStoreCompilerPass);
    }


    public function getContainerExtension()
    {
        return new BillsExtension;
    }

    private function buildMappingCompilerPass()
    {
        return DoctrineOrmMappingsPass::createXmlMappingDriver([
                __DIR__ . '/Resources/config/doctrine/' => 'HCLabs\Bills\Model'
            ]
        );
    }
}