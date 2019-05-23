<?php
namespace Classeeleve\Entity;
use Doctrine\ORM\Mapping as ORM;
use Classe\Entity\Classe;
use Eleve\Entity\Eleve;
use Anneescolaire\Entity\Anneescolaire;

/**
 * This class represents a single classe.
 * @ORM\Entity(repositoryClass="\Classeeleve\Repository\ClasseeleveRepository")
 * @ORM\Table(name="soft_tbl_classe_eleve")
 */
class Classeeleve 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Classe\Entity\Classe", inversedBy="classeeleve")
     * @ORM\JoinColumn(name="id_classe", referencedColumnName="id")
     */
    protected $classe;
    
   /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Eleve\Entity\Eleve", inversedBy="classeeleve")
     * @ORM\JoinColumn(name="id_eleve", referencedColumnName="id")
     */
    protected $eleve;
    
     /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Anneescolaire\Entity\Anneescolaire", inversedBy="anneescolaire")
     * @ORM\JoinColumn(name="id_anneescolaire", referencedColumnName="id")
     */
    protected $anneescolaire;
     
    
            
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
     * @return $eleve
     */
    public function getEleve() 
    {
        return $this->eleve;
    }
    
    /**
     * Adds a new comment to this post.
     * @param $eleve
     */
    public function addEleve($eleve) 
    {
        $this->eleve = $eleve;
    }
    
    /**
     * Returns horaires for this Enseignee.
     * @return $anneescolaire
     */
    public function getAnneescolaire() 
    {
        return $this->anneescolaire;
    }
    
    /**
     * Adds a new comment to this post.
     * @param $anneescolaire
     */
    public function addAnneescolaire($anneescolaire) 
    {
        $this->anneescolaire = $anneescolaire;
    }
    
    
    
}
