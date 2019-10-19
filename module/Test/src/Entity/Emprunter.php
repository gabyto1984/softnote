<?php
namespace Classe\Entity;
use Doctrine\ORM\Mapping as ORM;
use Enseignee\Entity\Enseignee;
use Classeeleve\Entity\Classeeleve;

/**
 * This class represents a single classe.
 * @ORM\Entity(repositoryClass="\Classe\Repository\ClasseRepository")
 * @ORM\Table(name="soft_tbl_classe")
 */
class Classe 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    /** 
     * @ORM\Column(name="libele")  
     */
    protected $libele;
    
    /** 
     * @ORM\Column(name="numero")  
     */
    protected $numero;
    
    /** 
     * @ORM\Column(name="quantite")  
     */
    protected $quantite;
    
     /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="\Enseignee\Entity\Enseignee", mappedBy="classe")
     */
    
    protected $enseignees;
    
   /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="\Classeeleve\Entity\Classeeleve", mappedBy="classe")
     */
    
    protected $classeEleve;
    
    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="\Evaluation\Entity\Evaluation", mappedBy="classe")
     */
    
    protected $evaluations;
    
     /**
     * Constructor.
     */
    public function __construct() 
    {
        $this->enseignees = new ArrayCollection();  
        $this->classeeleve = new ArrayCollection(); 
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
     * Returns probleme.
     * @return string
     */
    public function getLibele() 
    {
        return $this->libele;
    }
    /**
     * Sets title.
     * @param string $libele
     */
    public function setLibele($libele) 
    {
        $this->libele = $libele;
    }
    /**
     * Returns numero.
     * @return int
     */
    public function getNumero() 
    {
        return $this->numero;
    }
    /**
     * Sets title.
     * @param int $numero
     */
    public function setNumero($numero) 
    {
        $this->numero = $numero;
    }
    /**
     * Returns process.
     * @return int
     */
    public function getQuantite() 
    {
        return $this->quantite;
    }
    /**
     * Returns process.
     * @param int $quantite
     */
    public function setQuantite($quantite) 
    {
        $this->quantite = $quantite;
    }
    
    /**
     * Returns tags for this post.
     * @return array
     */
    public function getEnseignee() 
    {
        return $this->enseignees;
    }      
    
    /**
     * Adds a new tag to this post.
     * @param $enseignees
     */
    public function addEnseignees($enseignees) 
    {
        $this->enseignees[] = $enseignees;        
    }
    
    /**
     * Removes association between this classe and the given classe.
     * @param type $enseignees
     */
    public function removeEnseigneeAssociation($enseignees) 
    {
        $this->enseignees->removeElement($enseignees);
    }
    
     /**
     * Returns tags for this post.
     * @return array
     */
    public function getClasseEleve() 
    {
        return $this->classeEleve;
    }      
    
    /**
     * Adds a new tag to this post.
     * @param $classeEleve
     */
    public function addClasseEleve($classeEleve) 
    {
        $this->classeEleve[] = $classeEleve;        
    }
    
    /**
     * Removes association between this classe and the given matieres.
     * @param type $classeEleve
     */
    public function removeClasseEleveAssociation($classeEleve) 
    {
        $this->classeEleve->removeElement($classeEleve);
    }
    
     /**
     * Returns tags for this post.
     * @return array
     */
    public function getEvaluations() 
    {
        return $this->evaluations;
    }      
    
    /**
     * Adds a new tag to this post.
     * @param $evaluation
     *      */
    public function addEvaluations($evaluations) 
    {
        $this->evaluations[] = $evaluations;        
    }
    
   
}
