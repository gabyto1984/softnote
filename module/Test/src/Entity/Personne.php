<?php
namespace Test\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a single classe.
 * @ORM\Entity(repositoryClass="\Test\Repository\PersonneRepository")
 * @ORM\Table(name="test_personne")
 */
class Personne
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    /** 
     * @ORM\Column(name="nom")  
     */
    protected $nom;
    
    /** 
     * @ORM\Column(name="prenom")  
     */
    protected $prenom;
    
    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Emprunter", mappedBy="personne")
     */
    protected $emprunter;
    // ...

    public function __construct() {
        $this->emprunter = new ArrayCollection();
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
    public function getNom() 
    {
        return $this->nom;
    }
    /**
     * Sets title.
     * @param string $nom
     */
    public function setNom($nom) 
    {
        $this->nom = $nom;
    }
    
     /**
     * Returns probleme.
     * @return string
     */
    public function getPrenom() 
    {
        return $this->prenom;
    }
    /**
     * Sets title.
     * @param string $prenom
     */
    public function setPrenom($prenom) 
    {
        $this->prenom = $prenom;
    }
    
    /**
     * Returns tags for this post.
     * @return array
     */
    public function getEmprunter() 
    {
        return $this->emprunter;
    }      
    
    /**
     * Adds a new tag to this post.
     * @param $emprunter
     *      */
    public function addEmprunter($emprunter) 
    {
        $this->emprunter[] = $emprunter;        
    }
  
   
}
