<?php

namespace HCLabs\Bills\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Company
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var Service[]|Collection */
    private $services;

    private function __construct()
    {
        $this->services = new ArrayCollection;
    }

    /**
     * @param  string   $name
     * @return Company
     */
    public static function createWithoutServices($name)
    {
        $company = new Company;
        $company->name = $name;

        return $company;
    }

    /**
     * @param string    $name
     * @param Service[] $services
     * @return Company
     */
    public static function createAndOfferServices($name, array $services = array())
    {
        $company = new Company;
        $company->name = $name;

        foreach ($services as $service) {
            $company->offerService($service);
        }

        return $company;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Service $service
     */
    public function offerService(Service $service)
    {
        $this->services->add($service);
    }

    /**
     * @return Collection|Service[]
     */
    public function getOfferedServices()
    {
        return $this->services;
    }
}