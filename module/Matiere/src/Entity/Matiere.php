<?php
namespace Matiere\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Matiere\Entity\Discipline;
use Matiere\Entity\MatiereAffectee;
/**
 * This class represents a single matiere.
 * @ORM\Entity(repositoryClass="\Matiere\Repository\MatiereRepository")
 * @ORM\Table(name="soft_tbl_matiere_2")
 */
class Matiere 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    /** 
     * @ORM\Column(name="libele_matiere")  
     */
    protected $libele_matiere;
    
    /** 
     * @ORM\Column(name="abrege")  
     */
    protected $abrege;
    
    /** 
     * @ORM\Column(name="rang")  
     */
    protected $rang; 
    
    // rang matiere.
    const RANG_ORDINAIRE  = 0; // ORDINAIRE 
    const RANG_BASE  = 1; // BASE
  
     /**
     * @ORM\ManyToOne(targetEntity="\Matiere\Entity\Discipline", inversedBy="matieres")
     * @ORM\JoinColumn(name="id_discipline", referencedColumnName="id")
     */
    protected $discipline;
    
    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="\Matiere\Entity\MatiereAffectee", mappedBy="matiere")
     */
    protected $matiereaffectees;
    // ...

    public function __construct() {
        $this->matiereaffectees = new ArrayCollection();
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
     * Returns libele_matiere.
     * @return string
     */
    public function getLibeleMatiere() 
    {
        return $this->libele_matiere;
    }
    /**
     * Sets title.
     * @param string $libele_matiere
     */
    public function setLibeleMatiere($libele_matiere) 
    {
        $this->libele_matiere = $libele_matiere;
    }
    /**
     * Returns abrege.
     * @return string
     */
    public function getAbrege() 
    {
        return $this->abrege;
    }
    /**
     * Set abrege.
     * @param string $abrege
     */
    public function setAbrege($abrege) 
    {
        $this->abrege = $abrege;
    }
    
    /**
     * Returns sexe.
     * @return int     
     */
    public function getRang() 
    {
        return $this->rang;
    }

    /**
     * Returns possible sexe as array.
     * @return array
     */
    public static function getRangList() 
    {
        return [
            self::RANG_BASE=> 'BASE',
            self::RANG_ORDINAIRE => 'ORDINAIRE'
        ];
    }    
    
    /**
     * Returns  rang as string.
     * @return string
     */
    public function getRangAsString()
    {
        $list = self::getRangList();
        if (isset($list[$this->rang]))
            return $list[$this->rang];
        
        return 'Inconnu';
    }    
    
    /**
     * Sets .
     * @param int $rang     
     */
    public function setRang($rang) 
    {
        $this->rang = $rang;
    } 
    
    /*
     * Returns associated discipline.
     * @return \Matiere\Entity\Discipline
     */
    public function getDiscipline() 
    {
        return $this->discipline;
    }
    
    /**
     * Sets associated ticket.
     * @param  $discipline
     */
    public function setDiscipline($discipline) 
    {
        $this->discipline = $discipline;
        $discipline->addMatiere($this);
        return $this;
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
     * @param $matiereaffectee
     *      */
    public function addMatiereAffectee($mateiereaffectees) 
    {
        $this->matiereaffectees[] = $mateiereaffectees;
        $mateiereaffectees->addMatiere($this);  
        return $this;
    }
    
    public function removeMatiereAffectee(MatiereAffectee $matiereaffectees)
    {
       $this->matiereaffectees->removeElement($matiereaffectees);
     }   
  
}
