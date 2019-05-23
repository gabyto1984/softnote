<?php
namespace Eleve\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Eleve\Entity\Eleve;
use Evaluation\Entity\Evaluation;
use Classeeleve\Entity\Classeeleve;

/**
 * This class represents a single Eleve.
 * @ORM\Entity(repositoryClass="\Eleve\Repository\EleveRepository")
 * @ORM\Table(name="soft_tbl_eleve")
 */
class Eleve 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    /** 
     * @ORM\Column(name="nom")  
     */
    protected $nom_eleve;
    
    /** 
     * @ORM\Column(name="prenom")  
     */
    protected $prenom_eleve;
       
    /** 
     * @ORM\Column(name="date_naissance")  
     */
    protected $date_naissance;
    
     /** 
     * @ORM\Column(name="lieu_naissance")  
     */
    protected $lieu_naissance;
    
    /** 
     * @ORM\Column(name="sexe")  
     */
    protected $sexe;
    
    // sexe eleve.
    const SEXE_FEMININ  = 1; // FEMININ.
    const SEXE_MASCULIN  = 2; // MUSCULIN.
    const SEXE_AUTRE   = 3; // AUTRE.
    
     /** 
     * @ORM\Column(name="code_eleve")  
     */
    protected $code_eleve;
    
    /** 
     * @ORM\Column(name="statut")  
     */
    protected $status;
    
     // sexe eleve.
    const STATUS_INSCRIT  = 0; // INSCRIT.
    const STATUS_ACTIF  = 1; // ACTIF.
    const STATUS_ADMIS  = 2; // ADMIS.
    const STATUS_TERMINE   = 3; // TERMINE.
    const STATUS_EXPULSE   = 4; // EXPULSE.
    
        
    /** 
     * @ORM\Column(name="e_mail")  
     */
    protected $e_mail;
    
    /** 
     * @ORM\Column(name="photo")  
     */
    protected $photo;
    
     /**
     * @ORM\OneToMany(targetEntity="\Eleve\Entity\Contact", mappedBy="eleve")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_eleve")
     */
    protected $contacts;
    
     /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="\Classeeleve\Entity\Classeeleve", mappedBy="eleve")
     */
    
    protected $classeeleve;
    
    /**
     * One product has many features. This is the inverse side.
     * @ORM\OneToMany(targetEntity="\Evaluation\Entity\Evaluation", mappedBy="eleve")
     */
    
    protected $evaluations;
    
    /**
     * Constructor.
     */
    public function __construct() 
    {
        $this->contacts = new ArrayCollection();
        $this->classeeleve = new ArrayCollection();
        $this->evaluations = new ArrayCollection(); 
    }
    
    
    public function getId() 
    {
        return $this->id;
    }
    /**
     * id de l-eleve.
     * @param int $id
     */
    public function setId($id) 
    {
        $this->id = $id;
    }
    /**
     * Returns nom.
     * @return string
     */
    public function getNomEleve() 
    {
        return $this->nom_eleve;
    }
    /**
     * Sets nom eleve .
     * @param string $nom
     */
    public function setNomEleve($nom_eleve) 
    {
        $this->nom_eleve = $nom_eleve;
    }
    
    /**
     * Returns prenom.
     * @return string
     */
    public function getPrenomEleve() 
    {
        return $this->prenom_eleve;
    }
    /**
     * Sets prenom eleve .
     * @param string $prenom
     */
    public function setPrenomEleve($prenom_eleve) 
    {
        $this->prenom_eleve = $prenom_eleve;
    }
   
    /**
     * Sets date_naissance.
     * @param string $date_naissance
     */
    public function setDateNaissance($date_naissance) 
    {
        $this->date_naissance = $date_naissance;
    }
    /**
     * Returns date_naissance.
     * @return string
     */
    public function getDateNaissance() 
    {
        return $this->date_naissance;
    }
     
    /**
     * Sets lieu naissance
     * @param string $lieu_naissance
     */
    public function setLieuNaissance($lieu_naissance) 
    {
        $this->lieu_naissance = $lieu_naissance;
    }
    /**
     * Returns lieu naissance.
     * @return string
     */
    public function getLieuNaissance() 
    {
        return $this->lieu_naissance;
    }
    
     /**
     * Returns sexe.
     * @return int     
     */
    public function getSexe() 
    {
        return $this->sexe;
    }

    /**
     * Returns possible sexe as array.
     * @return array
     */
    public static function getSexeList() 
    {
        return [
            self::SEXE_FEMININ=> 'FEMININ',
            self::SEXE_MASCULIN => 'MASCULIN',
            self::SEXE_AUTRE => 'AUTRE'
        ];
    }    
    
    /**
     * Returns eleve sex as string.
     * @return string
     */
    public function getSexeAsString()
    {
        $list = self::getSexeList();
        if (isset($list[$this->sexe]))
            return $list[$this->sexe];
        
        return 'Inconnu';
    }    
    
    /**
     * Sets .
     * @param int $sexe     
     */
    public function setSexe($sexe) 
    {
        $this->sexe = $sexe;
    }  
    
     /**
     * Sets .
     * @param string $code_eleve
     */
    public function setCodeEleve($code_eleve) 
    {
        $this->code_eleve = $code_eleve;
    }
    /**
     * Returns code_eleve.
     * @return string
     */
    public function getCodeEleve() 
    {
        return $this->code_eleve;
    }
    
    /**
     * Returns status.
     * @return int     
     */
    public function getStatus() 
    {
        return $this->status;
    }

    /**
     * Returns possible status as array.
     * @return array
     */
    public static function getStatusList() 
    {
        return [
            self::STATUS_INSCRIT=> 'INSCRIT(E)',
            self::STATUS_ACTIF => 'ACTIF(VE)',
            self::STATUS_ADMIS => 'ADMIS(E)',
            self::STATUS_TERMINE => 'TERMINE(E)',
            self::STATUS_EXPULSE => 'EXPULSE(E)'
        ];
    }    
    
    /**
     * Returns eleve status as string.
     * @return string
     */
    public function getStatusAsString()
    {
        $list = self::getStatusList();
        if (isset($list[$this->status]))
            return $list[$this->status];
        
        return 'Inconnu';
    }    
    
    /**
     * Sets status.
     * @param int $status   
     */
    public function setStatus($status) 
    {
        $this->status = $status;
    } 
    
   
    
    /**
     * Sets e_mail.
     * @param string $e_mail
     */
    public function setEMail($e_mail) 
    {
        $this->e_mail = $e_mail;
    }
    /**
     * Returns e_mail.
     * @return string
     */
    public function getEMail() 
    {
        return $this->e_mail;
    }
    
     /**
     * Returns nom.
     * @return string
     */
    public function getPhotoEleve() 
    {
        return $this->photo;
    }
    /**
     * Sets photo eleve .
     * @param string $photo
     */
    public function setPhotoEleve($photo) 
    {
        $this->photo = $photo;
    }
    
     /**
     * Returns comments for this eleve.
     * @return array
     */
    public function getContacts() 
    {
        return $this->contacts;
    }
    
    /**
     * Adds a new comment to this post.
     * @param $contact
     */
    public function addContact($contact) 
    {
        $this->contacts[] = $contact;
    }
    
     /**
     * Returns tags for this post.
     * @return array
     */
    public function getClasseEleve() 
    {
        return $this->classeEleve;
    }      
    
    /**
     * Adds a new tag to this post.
     * @param $classeEleve
     */
    public function addClasseEleve($classeEleve) 
    {
        $this->classeEleve[] = $classeEleve;        
    }
    
    /**
     * Removes association between this classe and the given matieres.
     * @param type $classeEleve
     */
    public function removeClasseEleveAssociation($classeEleve) 
    {
        $this->classeEleve->removeElement($classeEleve);
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
     *      */
    public function addEvaluations($evaluations) 
    {
        $this->evaluations[] = $evaluations;        
    }
    
    
}
