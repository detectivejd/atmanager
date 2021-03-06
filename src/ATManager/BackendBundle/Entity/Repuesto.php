<?php

namespace ATManager\BackendBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Repuesto
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="ATManager\BackendBundle\Entity\RepuestoRepository")
 * @UniqueEntity(
 *     fields={"nombre"},
 *     message="Ya existe el nombre en otro item"
 * )
 */
class Repuesto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=80, unique=true, nullable=false)
     * @Assert\NotBlank()
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripamplia", type="text", nullable=true)
     */
    private $descripamplia;

    /**
     * @var string
     *
     * @ORM\Column(name="comentario", type="text", nullable=true)
     */
    private $comentario;
    /**
     * @ORM\ManyToOne(targetEntity="ATManager\BackendBundle\Entity\RepuestoClasif")
     * @ORM\JoinColumn(nullable=false)
     */
    private $clasif;	
    
    public function __construct(){
        
    }

    /*
    mis metodos
    */

    public function __toString(){
        return " ".$this->getNombre();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Repuesto
     */
    public function setNombre($nombre)
    {
        $this->nombre = strtoupper($nombre);

        return $this;
    }
    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripamplia
     *
     * @param string $descripamplia
     * @return Repuesto
     */
    public function setDescripamplia($descripamplia)
    {
        $this->descripamplia = $descripamplia;

        return $this;
    }
    /**
     * Get descripamplia
     *
     * @return string 
     */
    public function getDescripamplia()
    {
        return $this->descripamplia;
    }
    /**
     * Set comentario
     *
     * @param string $comentario
     * @return Repuesto
     */
    public function setComentario($comentario)
    {
        $this->comentario = $comentario;

        return $this;
    }

    /**
     * Get comentario
     *
     * @return string 
     */
    public function getComentario()
    {
        return $this->comentario;
    }
    /**
     * Set clasif
     *
     * @param \ATManager\BackendBundle\Entity\RepuestoClasif $clasif
     * @return Repuesto
     */
    public function setClasif(\ATManager\BackendBundle\Entity\RepuestoClasif $clasif = null)
    {
        $this->clasif = $clasif;

        return $this;
    }
    /**
     * Get clasif
     *
     * @return \ATManager\BackendBundle\Entity\RepuestoClasif 
     */
    public function getClasif()
    {
        return $this->clasif;
    }
}
