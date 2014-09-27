<?php

namespace HCLabs\Bills\Model;

use HCLabs\Bills\Value\Name;
use HCLabs\Bills\Value\ProvidedService;

class Service
{
    /** @var int */
    private $id;

    /** @var Company */
    private $company;

    /** @var string */
    private $serviceProvided;

    private function __construct(ProvidedService $service)
    {
        $this->serviceProvided = (string) $service;
    }

    /**
     * @param ProvidedService $service
     * @return Service
     */
    public static function fromName(ProvidedService $service)
    {
        return new self($service);
    }

    /**
     * @param ProvidedService $service
     * @param Company $company
     * @return Service
     */
    public static function offer(ProvidedService $service, Company $company)
    {
        $service = new self($service);
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
        return (string) $this->serviceProvided;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getProvidedService();
    }
}