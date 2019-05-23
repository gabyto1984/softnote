<?php
namespace Evaluation\Entity;
use Doctrine\ORM\Mapping as ORM;
use Matiere\Entity\Matiere;
use Classe\Entity\Classe;
use Enseignee\Entity\Enseignee;
use Periodeval\Entity\Periodeval;
use Eleve\Entity\Eleve;
use Classeeleve\Entity\Classeeleve;
use Anneescolaire\Entity\Anneescolaire;

/**
 * This class represents a single classe.
 * @ORM\Entity(repositoryClass="\Evaluation\Repository\EvaluationRepository")
 * @ORM\Table(name="soft_tbl_evaluation")
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
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Anneescolaire\Entity\Anneescolaire", inversedBy="evaluations")
     * @ORM\JoinColumn(name="id_annee", referencedColumnName="id")
     */
    protected $anneescolaire;
   
    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Periodeval\Entity\Periodeval", inversedBy="evaluations")
     * @ORM\JoinColumn(name="id_periodeval", referencedColumnName="id")
     */
    protected $periodeval;
    
     /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Classe\Entity\Classe", inversedBy="evaluations")
     * @ORM\JoinColumn(name="id_classe", referencedColumnName="id")
     */
    protected $classe;
    
    
   /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Matiere\Entity\Matiere", inversedBy="evaluations")
     * @ORM\JoinColumn(name="id_matiere", referencedColumnName="id")
     */
    protected $matiere;
    
    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="Eleve\Entity\Eleve", inversedBy="evaluations")
     * @ORM\JoinColumn(name="id_eleve", referencedColumnName="id")
     */
    protected $eleve; 
     
    /** 
     * @ORM\Column(name="note")  
     */
    protected $note;
      
    
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
        $anneescolaire->addEvaluation($this);
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
        $periodeval->addEvaluations($this);
    }
  
    
    /*
     * Returns associated eleve.
     * @return \Classe\Entity\Classe
     */
    public function getClasse() 
    {
        return $this->classe;
    }
    
    /**
     * Sets associated ticket.
     * @param \Classe\Entity\Classe $classe
     */
    public function setClasse($classe) 
    {
        $this->classe = $classe;
        $classe->addEvaluations($this);
    }
    
     /*
     * Returns associated eleve.
     * @return \Matiere\Entity\Matiere
     */
    public function getMatiere() 
    {
        return $this->matiere;
    }
    
    /**
     * Sets associated ticket.
     * @param \Matiere\Entity\Matiere $matiere
     */
    public function setMatiere($matiere) 
    {
        $this->matiere = $matiere;
        $matiere->addEvaluations($this);
    }
        
    /*
     * Returns associated eleve.
     * @return \Eleve\Entity\Eleve
     */
    public function getEleve() 
    {
        return $this->eleve;
    }
    
    /**
     * Sets associated ticket.
     * @param \Eleve\Entity\Eleve $eleve
     */
    public function setEleve($eleve) 
    {
        $this->eleve = $eleve;
        $eleve->addEvaluations($this);
    }
    
     
}
