<?php
namespace Classe\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Classe\Entity\Classe;
use Eleve\Entity\Eleve;

/**
 * This class represents a single classe.
 * @ORM\Entity(repositoryClass="\Classe\Repository\ClasseRepository")
 * @ORM\Table(name="soft_tbl_eleve_inscrit_2")
 */
class ClasseEleves 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="\Classe\Entity\Classe", inversedBy="classeeleve")
     * @ORM\JoinColumn(name="id_classe", referencedColumnName="id")
     */
    protected $classe;
    
    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="\Eleve\Entity\Eleve", inversedBy="classeeleve")
     * @ORM\JoinColumn(name="id_eleve", referencedColumnName="id")
     */
    protected $eleve;
    
     /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="\Evaluation\Entity\Evaluation", mappedBy="eleve_inscrit")
     */
    
    protected $evaluations;
    
        
    /**
     * Constructor.
     */
    public function __construct() 
    {
        $this->evaluations = new ArrayCollection();
    }
    
    
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
     * @return array
     */
    public function getEleve() 
    {
        return $this->eleve;
    }      
    
    /**
     * Adds a new tag to this post.
     * @param $eleve
     *      */
    public function addEleve(Eleve $eleve = null) 
    {
        $this->eleve = $eleve;        
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
        $evaluations->addClasseEleves($this);
        return $this;        
    }
   
}
