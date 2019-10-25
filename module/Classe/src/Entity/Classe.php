<?php
namespace Classe\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Salle\Entity\Salle;
use Classe\Entity\ClasseEleves;
use Matiere\Entity\MatiereAffectee;
use Anneescolaire\Entity\Anneescolaire;

/**
 * This class represents a single classe.
 * @ORM\Entity(repositoryClass="\Classe\Repository\ClasseRepository")
 * @ORM\Table(name="soft_tbl_classe_2")
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
     * @ORM\Column(name="niveau")  
     */
    protected $niveau;
    
    // sexe eleve.
    const NIVEAU_CYCLE1  = 1; // Premier cycle.
    const NIVEAU_CYCLE2  = 2; // Deuxieme cycle.
    const NIVEAU_CYCLE3   = 3; // Troisieme cycle.
   
        
     /**
     * One Cart has One Customer.
     * @ORM\OneToMany(targetEntity="\Salle\Entity\Salle", mappedBy="classe")
     */
    protected $salles;
      
    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="\Anneescolaire\Entity\Anneescolaire", inversedBy="classe")
     * @ORM\JoinColumn(name="id_anneescolaire", referencedColumnName="id")
     */
    protected $anneescolaire;
    
     /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="\Matiere\Entity\MatiereAffectee", mappedBy="classe")
     */
    protected $matiereaffectees;
    // ...
    
    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="\Classe\Entity\ClasseEleves", mappedBy="classe")
     */
    protected $classeeleves;

    public function __construct() {
        $this->salles = new ArrayCollection();
        $this->matiereaffectees = new ArrayCollection();
        $this->classeeleves = new ArrayCollection();
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
     * Returns sexe.
     * @return int     
     */
    public function getNiveau() 
    {
        return $this->niveau;
    }

    /**
     * Returns possible sexe as array.
     * @return array
     */
    public static function getNiveauList() 
    {
        return [
            self::NIVEAU_CYCLE1=> 'Premier cycle',
            self::NIVEAU_CYCLE2 => 'Deuxieme cycle',
            self::NIVEAU_CYCLE3 => 'Troisieme cycle'
        ];
    }    
    
    /**
     * Returns eleve sex as string.
     * @return string
     */
    public function getNiveauAsString()
    {
        $list = self::getNiveauList();
        if (isset($list[$this->niveau]))
            return $list[$this->niveau];
        
        return 'Inconnu';
    } 
    /**
     * Sets .
     * @param int $niveau     
     */
    public function setNiveau($niveau) 
    {
        $this->niveau = $niveau;
    }  
    
     /**
     * Returns tags for this post.
     * @return array
     */
    public function getSalle() 
    {
        return $this->salles;
    }  

    public function removeSalle(Salle $salle)
    {
    $this->salles->removeElement($salle);
     }    
    
    /**
     * Adds a new tag to this post.
     * @param $salles
     *      */
    public function addSalle(Salle $salle = null) 
    {
        $this->salles[] = $salle;  
        $salle->addClasse($this);
        return $this;
    }
    
    /**
     * Returns tags for this post.
     * @return array
     */
    public function getAnneeScolaire() 
    {
        return $this->anneescolaire;
    }      
    
    /**
     * Adds a new tag to this post.
     * @param $anneescolaire
     *      */
    public function addAnneeScolaire($anneescolaire) 
    {
        $this->anneescolaire = $anneescolaire;        
    }
    
     /**
     * Returns tags for this post.
     * @return array
     */
    public function getMatiereAffectee() 
    {
        return $this->matiereaffectees;
    }      
    
    /**
     * Adds a new tag to this post.
     * @param $matiereaffectees
     *      */
    public function addMatiereAffectee($matiereaffectees) 
    {
        $this->matiereaffectees[] = $matiereaffectees; 
        $matiereaffectees->addClasse($this);
        return $this;
    }
    
    public function removeMatiereAffectee(MatiereAffectee $matiereaffectee)
    {
    $this->matiereaffectees->removeElement($matiereaffectee);
     }   
    
     /**
     * Returns tags for this post.
     * @return array
     */
    public function getClasseEleves() 
    {
        return $this->classeeleves;
    }      
    
    /**
     * Adds a new tag to this post.
     * @param $classeeleves
     *      */
    public function addClasseEleves($classeeleves) 
    {
        $this->classeeleves[] = $classeeleves;
        $classeeleves->addClasse($this);
        return $this;
    }
    
     public function removeClasseEleves(ClasseEleves $classeeleves)
    {
    $this->classeeleves->removeElement($classeeleves);
     }   
  
   
}
