<?php

namespace HCLabs\Bills\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HCLabs\Bills\Model\Service;
use HCLabs\Bills\Value\ProvidedService;

class LoadServiceData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    function load(ObjectManager $manager)
    {
        $service = Service::offer(
            new ProvidedService('100MB Internet'),
            $this->getReference('company_vm')
        );

        $this->setReference('service_internet', $service);

        $manager->persist($service);
        $manager->flush();
    }

    /**
     * {@inheritdoc}
     */
    function getOrder()
    {
        return 2;
    }

}