<?php
namespace Periodeval\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Evaluation\Entity\Evaluation;
use Periodeval\Entity\Pdecisionnelle;
use Enseignee\Entity\Enseignee;
/**
 * This class represents a single matiere.
 * @ORM\Entity(repositoryClass="\Periodeval\Repository\PeriodevalRepository")
 * @ORM\Table(name="soft_tbl_periode_evaluation_2")
 */
class Periodeval 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    /** 
     * @ORM\Column(name="description")  
     */
    protected $description;
    
    /**
     * @ORM\Column(name="date_debut")  
     */
    protected $date_debut;
    
     /**
     * @ORM\Column(name="date_fin")  
     */
    protected $date_fin;
            
    /** 
     * @ORM\Column(name="commentaires")  
     */
    protected $commentaires;
        
     /**
     * @ORM\ManyToOne(targetEntity="Anneescolaire\Entity\Anneescolaire", inversedBy="periodevals")
     * @ORM\JoinColumn(name="id_annee", referencedColumnName="id")
     */
    protected $anneescolaire;
    
    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="\Evaluation\Entity\Evaluation", mappedBy="periodeval")
     */
    
    protected $evaluations;
    
     /**
     * @ORM\ManyToOne(targetEntity="\Periodeval\Entity\Pdecisionnelle", inversedBy="periodeval")
     * @ORM\JoinColumn(name="id_pdecisionnelle", referencedColumnName="id")
     */
    protected $pdecisionnelle;
    
        
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
     * Returns libele.
     * @return string
     */
    public function getDescription() 
    {
        return $this->description;
    }
    /**
     * Sets title.
     * @param string $description
     */
    public function setDescription($description) 
    {
        $this->description = $description;
    }
    
    /**
     * Returns libele.
     * @return string
     */
    public function getDateDebut() 
    {
        return $this->date_debut;
    }
    /**
     * Sets title.
     * @param string $date_debut
     */
    public function setDateDebut($date_debut) 
    {
        $this->date_debut = $date_debut;
    }
    
    /**
     * Returns date_fin.
     * @return string
     */
    public function getDateFin() 
    {
        return $this->date_fin;
    }
    /**
     * Sets title.
     * @param string $date_fin
     */
    public function setDateFin($date_fin) 
    {
        $this->date_fin = $date_fin;
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
    
      /*
     * Returns associated discipline.
     * @return \Periodeval\Entity\Pdecisionnelle
     */
    public function getPeriode() 
    {
        return $this->pdecisionnelle;
    }
    
    /**
     * Sets associated ticket.
     * @param  $pdecisionnelle
     */
    public function setPeriode($pdecisionnelle) 
    {
        $this->pdecisionnelle = $pdecisionnelle;
        $pdecisionnelle->addPeriode($this);
        return $this;
    }
    
     /*
     * Returns associated eleve.
     * @return \Anneescolaire\Entity\Anneescolaire
     */
    public function getAnneeScolaire() 
    {
        return $this->anneescolaire;
    }
    
    /**
     * Sets associated ticket.
     * @param \Anneescolaire\Entity\Anneescolaire $anneescolaire
     */
    public function setAnneeScolaire($anneescolaire) 
    {
        $this->anneescolaire = $anneescolaire;
        $anneescolaire->addPeriodEval($this);
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
        $evaluations->getPeriodeval($this); 
        return $this;
    }
   
}
