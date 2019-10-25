<?php
namespace Matiere\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Matiere\Entity\Matiere;

/**
 * This class represents a single discipline.
 * @ORM\Entity(repositoryClass="\Matiere\Repository\DisciplineRepository")
 * @ORM\Table(name="soft_tbl_discipline_2")
 */
class Discipline 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    /** 
     * @ORM\Column(name="libele_discipline")  
     */
    protected $libele_discipline;
    
    /** 
     * @ORM\Column(name="abrege")  
     */
    protected $abrege;
    
     /**
     * @ORM\OneToMany(targetEntity="\Matiere\Entity\Matiere", mappedBy="discipline")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_discipline")
     */
    protected $matieres;
    
     /**
     * Constructor.
     */
    public function __construct() 
    {
        $this->matieres = new ArrayCollection();               
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
    public function getLibeleDiscipline() 
    {
        return $this->libele_discipline;
    }
    /**
     * Sets title.
     * @param string $libele_discipline
     */
    public function setLibeleDiscipline($libele_discipline) 
    {
        $this->libele_discipline = $libele_discipline;
    }
    
     /**
     * Returns libele_matiere.
     * @return string
     */
    public function getAbrege() 
    {
        return $this->abrege;
    }
    /**
     * Sets title.
     * @param string $abrege
     */
    public function setAbrege($abrege) 
    {
        $this->abrege = $abrege;
    }
    
     /**
     * Returns comments for this eleve.
     * @return array
     */
    public function getMatieres() 
    {
        return $this->matieres;
    }
    
    /**
     * Adds a new comment to this post.
     * @param $matiere
     */
    public function addMatiere($matiere) 
    {
        $this->matieres[] = $matiere;
    }
    
}
