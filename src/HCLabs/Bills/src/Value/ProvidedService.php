<?php

namespace HCLabs\Bills\Value;

final class ProvidedService
{
    /** @var string */
    private $providedService;

    /**
     * @param $providedService
     */
    public function __construct($providedService)
    {
        \Assert\that($providedService)->string();

        $this->providedService = $providedService;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->providedService;
    }
}