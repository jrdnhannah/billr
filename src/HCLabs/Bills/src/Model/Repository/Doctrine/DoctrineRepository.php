<?php

namespace HCLabs\Bills\Model\Repository\Doctrine;

use Doctrine\ORM\EntityRepository;

abstract class DoctrineRepository extends EntityRepository
{
    /**
     * @param object $model
     */
    protected function saveModel($model)
    {
        $em = $this->getEntityManager();

        if (false === $em->contains($model)) {
            $em->persist($model);
        }

        $em->flush($model);
    }
}