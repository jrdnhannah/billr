<?php

namespace HCLabs\Bills\Value;

class UUID
{
    /** @var string */
    private $id;

    /**
     * @param string $id
     */
    public function __construct($id)
    {
        \Assert\that($id)->string();
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id;
    }
}