<?php
namespace Evaluation\Entity;
use Doctrine\ORM\Mapping as ORM;
use Classe\Entity\ClasseEleves;
use Matiere\Entity\MatiereAffectee;
use Periodeval\Entity\Periodeval;

/**
 * This class represents a single classe.
 * @ORM\Entity(repositoryClass="\Evaluation\Repository\EvaluationRepository")
 * @ORM\Table(name="soft_tbl_evaluation_2")
 */
class Evaluation
 
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
   
     
    /** 
     * @ORM\Column(name="note")  
     */
    protected $note;
    
        
    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Periodeval\Entity\Periodeval", inversedBy="evaluations")
     * @ORM\JoinColumn(name="id_periode_evaluation", referencedColumnName="id")
     */
    protected $periodeval;
    
     /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Classe\Entity\ClasseEleves", inversedBy="evaluations")
     * @ORM\JoinColumn(name="id_eleve_inscrit", referencedColumnName="id")
     */
    protected $eleve_inscrit;
    
    
   /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Matiere\Entity\MatiereAffectee", inversedBy="evaluations")
     * @ORM\JoinColumn(name="id_matiere_affectee", referencedColumnName="id")
     */
    protected $matiere_affectee;
      
    
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
     * Returns note.
     * @return int
     */
    public function getNote() 
    {
        return $this->note;
    }
    /**
     * Sets coeff.
     * @param int $note
     */
    public function setNote($note) 
    {
        $this->note = $note;
    }
    
     /*
     * Returns associated eleve.
     * @return \Periodeval\Entity\Periodeval
     */
    public function getPeriodeval() 
    {
        return $this->periodeval;
    }
    
    /**
     * Sets associated ticket.
     * @param \Periodeval\Entity\Periodeval $periodeval
     */
    public function setPeriodeval($periodeval) 
    {
        $this->periodeval = $periodeval;
        //$periodeval->addEvaluations($this);
        //return $this;
    }
    
    
    /*
     * Returns associated eleve.
     * @return \Classe\Entity\ClasseEleves
     */
    public function getEleveInscrit() 
    {
        return $this->eleve_inscrit;
    }
    
    /**
     * Sets associated ticket.
     * @param \Classe\Entity\ClasseEleves  $eleve_inscrit
     */
    public function setEleveInscrit($eleve_inscrit) 
    {
        $this->eleve_inscrit = $eleve_inscrit;
        //$eleve_inscrit->addEvaluations($this);
        //return $this;
    }
    
    /*
     * Returns associated eleve.
     * @return \Matiere\Entity\MatiereAffectee
     */
    public function getMatiereAffectee() 
    {
        return $this->matiere_affectee;
    }
    
    /**
     * Sets associated ticket.
     * @param \Matiere\Entity\MatiereAffectee $matiere_affectee
     */
    public function setMatiereAffectee($matiere_affectee) 
    {
        $this->matiere_affectee = $matiere_affectee;
       // $matiere_affectee->addEvaluations($this);
       // return $this;
    }
    
}
