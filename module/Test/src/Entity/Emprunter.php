<?php
namespace Test\Entity;
use Doctrine\ORM\Mapping as ORM;
use Test\Entity\Personne;
use Test\Entity\Livre;

/**
 * This class represents a single classe.
 * @ORM\Entity(repositoryClass="\Test\Repository\EmprunterRepository")
 * @ORM\Table(name="test_emprunter")
 */
class Emprunter 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    
   /**
     * @ORM\Column(name="date_emprunt")  
     */
    protected $date_emprunt;
    
   /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Personne", inversedBy="emprunter")
     * @ORM\JoinColumn(name="id_personne", referencedColumnName="id")
     */
    protected $personne;
    
    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Livre", inversedBy="emprunter")
     * @ORM\JoinColumn(name="id_livre", referencedColumnName="id")
     */
    protected $livre;
    
               
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
     * @return date
     */
    public function getDateEmprunt() 
    {
        return $this->date_emprunt;
    }
    /**
     * Sets title.
     * @param date $date_emprunt
     */
    public function setDateEmprunt($date_emprunt) 
    {
        $this->date_emprunt = $date_emprunt;
    }
   
       
     /**
     * Returns tags for this post.
     * @return array
     */
    public function getPersonne() 
    {
        return $this->personne;
    }      
    
    /**
     * Adds a new tag to this post.
     * @param $personne
     *      */
    public function addPersonne($personne) 
    {
        $this->personne[] = $personne;        
    }
    
     /**
     * Returns tags for this post.
     * @return array
     */
    public function getLivre() 
    {
        return $this->livre;
    }      
    
    /**
     * Adds a new tag to this post.
     * @param $livre
     *      */
    public function addLivre($livre) 
    {
        $this->livre[] = $livre;        
    }
    
   
}
