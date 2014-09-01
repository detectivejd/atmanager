<?php

namespace ATManager\AtBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * AtFallaRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AtFallaRepository extends EntityRepository
{

    public function findByFallasPorAt($at)
    {
        $em = $this->getEntityManager();		  	
        $query = $em->createQuery('SELECT f FROM AtBundle:AtFalla f WHERE f.at = :at')
            ->setParameter('at', $at);
        $query->setMaxResults(50);
        return $query->getResult();
    }


}
