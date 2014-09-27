<?php

namespace HCLabs\Bills\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use HCLabs\Bills\Value\CompanyName;

class Company
{
    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var Service[]|Collection */
    private $services;

    private function __construct(CompanyName $name)
    {
        $this->services = new ArrayCollection;
        $this->name = (string) $name;
    }

    /**
     * @param  CompanyName     $name
     * @return Company
     */
    public static function createWithoutServices(CompanyName $name)
    {
        return new self($name);
    }

    /**
     * @param CompanyName      $name
     * @param Service[] $services
     * @return Company
     */
    public static function createAndOfferServices(CompanyName $name, array $services = array())
    {
        $company = new self($name);

        foreach ($services as $service) {
            $company->offerService($service);
        }

        return $company;
    }

    /**
     * @return CompanyName
     */
    public function getName()
    {
        return new CompanyName($this->name);
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