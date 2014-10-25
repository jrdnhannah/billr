<?php

namespace HCLabs\Bills\Fixtures;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use HCLabs\Bills\Billing\BillingPeriod\Monthly;
use HCLabs\Bills\Model\Account;
use HCLabs\Bills\Value\AccountNumber;
use HCLabs\Bills\Value\BillingPeriod;
use HCLabs\Bills\Value\Money;

class LoadAccountData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritdoc}
     */
    function load(ObjectManager $manager)
    {
        $account = Account::open(
            $this->getReference('service_internet'),
            new AccountNumber('abc123'),
            Money::fromFloat(27.50),
            new \DateTime('now'),
            new BillingPeriod('P1M')
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