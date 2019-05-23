<?php
namespace Enseignee\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a single horaire .
 * @ORM\Entity(repositoryClass="\Enseignee\Repository\HoraireRepository")
 * @ORM\Table(name="soft_tbl_horaire")
 */
class Horaire
 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
      
    /** 
     * @ORM\Column(name="horaire_date")  
     */
    protected $horaire_date;
    
     /** 
     * @ORM\Column(name="heures")  
     */
    
    protected $heures;
    
   
              
    public function getId() 
    {
        return $this->id;
    }
    /**
     * Sets ID of this classe.
     * @param int $id
     */
    public function setId($id) 
    {
        $this->id = $id;
    }
    
    /**
     * Returns coefficient.
     * @return string
     */
    public function getDateHoraire() 
    {
        return $this->horaire_date;
    }
    /**
     * Sets coeff.
     * @param string $horaire_date
     */
    public function setDateHoraire($horaire_date) 
    {
        $this->horaire_date = $horaire_date;
    }
    /**
     * Returns coefficient.
     * @return string
     */
    public function getHeures() 
    {
        return $this->heures;
    }
    /**
     * Sets coeff.
     * @param string $horaire_date
     */
    public function setHeures($heures) 
    {
        $this->heures = $heures;
    }
    
   
}
