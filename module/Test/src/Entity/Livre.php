<?php
namespace Test\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a single classe.
 * @ORM\Entity(repositoryClass="\Test\Repository\LivreRepository")
 * @ORM\Table(name="test_livre")
 */
class Livre 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    /** 
     * @ORM\Column(name="titre")  
     */
    protected $titre;
    
    /** 
     * @ORM\Column(name="numero")  
     */
    protected $numero;
    
    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="Emprunter", mappedBy="livre")
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
    public function getTitre() 
    {
        return $this->titre;
    }
    /**
     * Sets title.
     * @param string $titre
     */
    public function setTitre($titre) 
    {
        $this->titre = $titre;
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
