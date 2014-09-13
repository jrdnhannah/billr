<?php

namespace HCLabs\Bills\Model;

class Service
{
    /** @var int */
    private $id;

    /** @var Company */
    private $company;

    /** @var string */
    private $serviceProvided;

    private function __construct()
    {
    }

    /**
     * @param  string   $name
     * @return Service
     */
    public static function fromName($name)
    {
        $service = new Service;
        $service->serviceProvided = $name;

        return $service;
    }

    /**
     * @param string    $providedService
     * @param Company   $company
     * @return Service
     */
    public static function offer($providedService, Company $company)
    {
        $service = self::fromName($providedService);
        $service->company = $company;

        return $service;
    }

    /**
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @return string
     */
    public function getProvidedService()
    {
        return $this->serviceProvided;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getProvidedService();
    }
}