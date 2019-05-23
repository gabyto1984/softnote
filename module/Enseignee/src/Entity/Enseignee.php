<?php
namespace Enseignee\Entity;
use Doctrine\ORM\Mapping as ORM;
use Matiere\Entity\Matiere;
use Classe\Entity\Classe;
use Evaluation\Entity\Evaluation;
use Periodeval\Entity\Periodeval;

/**
 * This class represents a single classe.
 * @ORM\Entity(repositoryClass="\Enseignee\Repository\EnseigneeRepository")
 * @ORM\Table(name="soft_tbl_classe_matiere")
 */
class Enseignee
 
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Periodeval\Entity\Periodeval", inversedBy="enseignees")
     * @ORM\JoinColumn(name="id_periodeval", referencedColumnName="id")
     */
    protected $periodeval;
   
    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Classe\Entity\Classe", inversedBy="enseignees")
     * @ORM\JoinColumn(name="id_classe", referencedColumnName="id")
     */
    protected $classe;
    
   /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Matiere\Entity\Matiere", inversedBy="enseignees")
     * @ORM\JoinColumn(name="id_matiere", referencedColumnName="id")
     */
    protected $matiere;
    
         
    /** 
     * @ORM\Column(name="coefficient")  
     */
    protected $coefficient;
    
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
     * @return int
     */
    public function getCoefficient() 
    {
        return $this->coefficient;
    }
    /**
     * Sets coeff.
     * @param int $coefficient
     */
    public function setCoefficient($coefficient) 
    {
        $this->coefficient = $coefficient;
    }
    
     /**
     * Returns horaires for this Enseignee.
     * @return $periodeval
     */
    public function getPeriodeval() 
    {
        return $this->periodeval;
    }
    
    /**
     * Adds a new comment to this post.
     * @param $periodeval
     */
    public function addPeriodeval($periodeval) 
    {
        $this->periodeval = $periodeval;
    }
      
     /**
     * Returns horaires for this Enseignee.
     * @return $classe
     */
    public function getClasse() 
    {
        return $this->classe;
    }
    
    /**
     * Adds a new comment to this post.
     * @param $classe
     */
    public function addClasse($classe) 
    {
        $this->classe = $classe;
    }
    /**
     * Returns horaires for this Enseignee.
     * @return $matiere
     */
    public function getMatiere() 
    {
        return $this->matiere;
    }
    
    /**
     * Adds a new comment to this post.
     * @param $matiere
     */
    public function addMatiere($matiere) 
    {
        $this->matiere = $matiere;
    }
    
   
    
}
