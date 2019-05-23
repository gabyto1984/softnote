<?php
namespace Anneescolaire\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Periodeval\Entity\Periodeval;
/**
 * This class represents a single Periode.
 * @ORM\Entity(repositoryClass="\Anneescolaire\Repository\AnneescolaireRepository")
 * @ORM\Table(name="soft_tbl_annee_scolaire")
 */
class Anneescolaire 
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
     * @ORM\Column(name="statut")  
     */
    protected $statut;
    
       
     // sexe eleve.
    const ANNEE_CREEE  = 1; // INSCRIT.
    const ANNEE_ACTIVE  = 2; // ACTIF.
    const ANNEE_ENCOURS  = 3; // ADMIS.
    const ANNEE_PASSEE   = 4; // TERMINE.
       
    /** 
     * @ORM\Column(name="commentaires")  
     */
    protected $commentaires; 
    
     /**
     * @ORM\OneToMany(targetEntity="\Periodeval\Entity\Periodeval", mappedBy="anneescolaire")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_annee")
     */
    protected $periodevals;
    
     /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="\Classeeleve\Entity\Classeeleve", mappedBy="classe")
     */
    
    protected $classeeleves;
    
     /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="\Evaluation\Entity\Evaluation", mappedBy="anneescolaire")
     */
    
    protected $evaluations;
    
    
    /**
     * Constructor.
     */
    public function __construct() 
    {
        $this->periodevals = new ArrayCollection();
        $this->classeeleves = new ArrayCollection();
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
     * Returns libele.
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
    public function getStatut() 
    {
        return $this->statut;
    }

    /**
     * Returns possible sexe as array.
     * @return array
     */
    public static function getStatutList() 
    {
        return [
            self::ANNEE_CREEE=> 'CREEE',
            self::ANNEE_ACTIVE => 'ACTIVE',
            self::ANNEE_ENCOURS=> 'EN COURS',
            self::ANNEE_PASSEE => 'PASSEE'
        ];
    }    
    
    /**
     * Returns  rang as string.
     * @return string
     */
    public function getStatutAsString()
    {
        $list = self::getStatutList();
        if (isset($list[$this->statut]))
            return $list[$this->statut];
        
        return 'Inconnu';
    }    
    
    /**
     * Sets .
     * @param int $statut     
     */
    public function setStatut($statut) 
    {
        $this->statut = $statut;
    } 
    
     /**
     * Returns libele.
     * @return string
     */
    public function getCommentaires() 
    {
        return $this->commentaires;
    }
    /**
     * Sets title.
     * @param string $commentaires
     */
    public function setCommentaires($commentaires) 
    {
        $this->commentaires = $commentaires;
    }
    
    /**
     * Returns comments for this annee.
     * @return \Evaluation\Entity\Evaluation 
     */
    public function getEvaluation() 
    {
        return $this->evaluations;
    }
    
    /**
     * Adds a new comment to this post.
     * @param \Evaluation\Entity\Evaluation $evaluations
     */
    public function addEvaluation($evaluations) 
    {
        $this->evaluations[] = $evaluations;
    }
    
     /**
     * Returns comments for this annee.
     * @return \Periodeval\Entity\Periodeval 
     */
    public function getPeriodEval() 
    {
        return $this->periodevals;
    }
    
    /**
     * Adds a new comment to this post.
     * @param \Periodeval\Entity\Periodeval $periodevals
     */
    public function addPeriodEval($periodevals) 
    {
        $this->periodevals[] = $periodevals;
    }
    
     /**
     * Returns comments for this annee.
     * @return \Classeeleve\Entity\Classeeleve 
     */
    public function getClasseeleves() 
    {
        return $this->classeeleves;
    }
    
    /**
     * Adds a new comment to this post.
     * @param \Classeeleve\Entity\Classeeleve $classeeleves
     */
    public function addClasseeleves($classeeleves) 
    {
        $this->$classeeleves[] = $classeeleves;
    }
    
   
}
