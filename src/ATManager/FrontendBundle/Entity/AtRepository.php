<?php

namespace ATManager\FrontendBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;
use ATManager\AtBundle\Entity\AtHistorico;

/**
 * AtRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class AtRepository extends EntityRepository
{
	public function findByFiltroAt($numero, $personasolicita, $sectorsolicita)
	{
			
		// if (!isset($numero) and !isset($personasolicita) and !isset($sectorsolicita))
		
			$em = $this->getEntityManager();
			$query = $em->createQueryBuilder()
			->select('a')
			->from('FrontendBundle:At','a')
			->where('1 = 1');
			if ($numero)
			{
			$query->andWhere('a.id = :id');
			$query->setParameter('id',$numero);
			}
			if ($personasolicita)
			{
			$query->andWhere('a.personasolicita LIKE :personasolicita');
			$query->setParameter('personasolicita','%'.$personasolicita.'%');
			}
			if ($sectorsolicita)
		    {
	    	$query->andWhere('a.sectorsolicita = :sectorsolicita');
			$query->setParameter('sectorsolicita',$sectorsolicita);
		    }
		    
			$query->setMaxResults(50);
			$query = $query->getQuery();
			return $query->getResult();
			
	}


	public function findByFiltroPorSectorEstadio($sector, $estadio)
	{

			$em = $this->getEntityManager();		  	
			$query = $em->createQuery('SELECT a
			FROM FrontendBundle:At a
			INNER JOIN AtBundle:AtHistorico h WITH a.id = h.at
			WHERE a.sectordestino = :sector
			AND h.estadio = :estadio
			AND h.estadio = (SELECT IDENTITY(h1.estadio)
			FROM AtBundle:AtHistorico h1 
			WHERE h1.fecha = (
			SELECT max(h2.fecha)
			FROM AtBundle:AtHistorico h2
			WHERE h2.at = a.id))')
				
			->setParameter('sector', $sector)
    		->setParameter('estadio', $estadio);

    		$query->setMaxResults(50);
			return $query->getResult();
	}

	public function findByFiltroUltimoEstadio($at)
	{
			echo $at;
			$em = $this->getEntityManager();		  	
			$query = $em->createQuery('SELECT IDENTITY(h1.estadio)
			FROM AtBundle:AtHistorico h1 
			WHERE h1.fecha = (SELECT max(h2.fecha)
			FROM AtBundle:AtHistorico h2 WHERE h2.at = :at )')			
			->setParameter('at', $at);

     		   
			$estadio = $query->getOneOrNullResult();
			echo "Estadio: ".$estadio;
			return $estadio;			   		
	}
        // recibe el técnico y rol cómo parámetros y devuelve un array con 
        // las ats asignadas al técnico
        public function findByFiltroPorTecnico($tecnico,$rol,$estadio)
	{
            $em = $this->getEntityManager();		  	
            $query = $em->createQuery('SELECT a
                FROM FrontendBundle:At a
                INNER JOIN AtBundle:AtTecnico t with a.id = t.at
		INNER JOIN AtBundle:AtHistorico h with a.id=h.at 
                WHERE t.tecnico = :tecnico 
                AND h.estadio= :estadio
		AND t.rol = :rol')
                ->setParameter('tecnico', $tecnico)
                ->setParameter('rol', $rol)
                ->setParameter('estadio', $estadio);
            $query->setMaxResults(50);
            return $query->getResult();
	}
}
