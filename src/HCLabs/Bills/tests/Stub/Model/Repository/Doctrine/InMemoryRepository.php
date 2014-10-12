<?php

namespace HCLabs\Bills\Tests\Stub\Model\Repository\Doctrine;

use HCLabs\Bills\Model\Repository\Doctrine\DoctrineRepository;

abstract class InMemoryRepository extends DoctrineRepository
{
    public function __construct()
    {
    }

    /**
     * @var object[]
     */
    private $models = [];

    protected function saveModel($model)
    {
        $this->models[] = $model;
    }

    /**
     * @return object[]
     */
    public function findAll()
    {
        return $this->models;
    }
}