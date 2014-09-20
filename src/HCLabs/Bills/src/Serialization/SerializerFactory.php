<?php

namespace HCLabs\Bills\Serialization;

use HCLabs\Bills\Model\Bill;
use HCLabs\Bills\Serialization\Handler\BillHandler;
use JMS\Serializer\Handler\HandlerRegistryInterface;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;

class SerializerFactory
{
    /**
     * @return \JMS\Serializer\SerializerInterface
     */
    public static function create()
    {
        $serializer = SerializerBuilder::create();
        $serializer->setDebug(true);

        self::registerBillHandler($serializer);

        return $serializer->build();
    }

    private static function registerBillHandler(SerializerBuilder $serializer)
    {
        $serializer
            ->addDefaultHandlers()
            ->addMetadataDir(__DIR__ . '/../Resources/serialization/model');
    }
}