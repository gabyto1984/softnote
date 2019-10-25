<?php
namespace Matiere\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Matiere\Entity\Matiere;
use Classe\Entity\Classe;
/**
 * This class represents a single matiere.
 * @ORM\Entity(repositoryClass="\Matiere\Repository\MatiereAffecteeRepository")
 * @ORM\Table(name="soft_tbl_matiere_affectee_2")
 */
class MatiereAffectee 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="\Matiere\Entity\Matiere", inversedBy="matiereaffectee")
     * @ORM\JoinColumn(name="id_matiere", referencedColumnName="id")
     */
    protected $matiere;
    
    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="\Classe\Entity\Classe", inversedBy="matiereaffectee")
     * @ORM\JoinColumn(name="id_classe", referencedColumnName="id")
     */
    protected $classe;
    
    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="\Evaluation\Entity\Evaluation", mappedBy="matiere_affectee")
     */
    
    protected $evaluations;
    
     
    
    public function __construct() {
        $this->evaluations = new ArrayCollection();
    }
    
         
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
     * Returns tags for this post.
     * @return array
     */
    public function getMatiere() 
    {
        return $this->matiere;
    }      
    
    /**
     * Adds a new tag to this post.
     * @param $matiere
     *      */
    public function addMatiere($matiere) 
    {
        $this->matiere = $matiere;        
    }
    
     /**
     * Returns tags for this post.
     * @return array
     */
    public function getClasse() 
    {
        return $this->classe;
    }      
    
    /**
     * Adds a new tag to this post.
     * @param $classe
     *      */
    public function addClasse($classe) 
    {
        $this->classe = $classe;        
    }
    
    /**
     * Returns tags for this post.
     * @return \Evaluation\Entity\Evaluation
     */
    public function getEvaluations() 
    {
        return $this->evaluations;
    }      
    
    /**
     * Adds a new tag to this post.
     * @param \Evaluation\Entity\Evaluation $evaluations
     */
    public function addEvaluations($evaluations) 
    {
        $this->evaluations[] = $evaluations; 
        $evaluations->setMatiereAffectee($this);
        return $this;
    }
    
}
