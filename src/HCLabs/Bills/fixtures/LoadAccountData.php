<?php

namespace HCLabs\Bills\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HCLabs\Bills\Billing\BillingPeriod\Monthly;
use HCLabs\Bills\Model\Account;

class LoadAccountData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    function load(ObjectManager $manager)
    {
        $account = Account::open(
            $this->getReference('service_internet'),
            'abc123',
            27.50,
            new \DateTime('now'),
            new Monthly
        );

        $manager->persist($account);
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 3;
    }
}