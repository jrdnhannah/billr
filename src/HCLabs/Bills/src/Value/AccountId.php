<?php

namespace HCLabs\Bills\Value;

final class AccountId
{
    /** @var string */
    private $accountId;

    /**
     * @param string $accountId
     */
    public function __construct($accountId)
    {
        \Assert\that($accountId)->string();
        $this->accountId = $accountId;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->accountId;
    }
}