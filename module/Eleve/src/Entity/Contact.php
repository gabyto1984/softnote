<?php
namespace Eleve\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents a single Contact.
 * @ORM\Entity(repositoryClass="\Eleve\Repository\EleveRepository")
 * @ORM\Table(name="soft_tbl_contact_eleve")
 */
class Contact 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    /** 
     * @ORM\Column(name="nom_parent")  
     */
    protected $nom_parent;
    
    /** 
     * @ORM\Column(name="prenom_parent")  
     */
    protected $prenom_parent;
    
    /** 
     * @ORM\Column(name="domicile")  
     */
    protected $domicile;
        
     /** 
     * @ORM\Column(name="telephone1")  
     */
    protected $telephone1;
    
    /** 
     * @ORM\Column(name="telephone2")  
     */
    protected $telephone2;
    
    /** 
     * @ORM\Column(name="email_parent")  
     */
    protected $email_parent;
    
    /** 
     * @ORM\Column(name="commentaires")  
     */
    protected $commentaires;
    
     /**
     * @ORM\ManyToOne(targetEntity="Eleve\Entity\Eleve", inversedBy="contact")
     * @ORM\JoinColumn(name="id_eleve", referencedColumnName="id")
     */
    protected $eleve;
    
    
    public function getId() 
    {
        return $this->id;
    }
    /**
     * Sets ID of this update.
     * @param int $id
     */
    public function setId($id) 
    {
        $this->id = $id;
    }
    /**
     * Returns nom parent.
     * @return string
     */
    public function getNomParent() 
    {
        return $this->nom_parent;
    }
    /**
     * Sets title.
     * @param string $nom_parent
     */
    public function setNomParent($nom_parent) 
    {
        $this->nom_parent = $nom_parent;
    }
    
    /**
     * Returns prenom parent.
     * @return string
     */
    public function getPrenomParent() 
    {
        return $this->prenom_parent;
    }
    /**
     * Sets prenom parent.
     * @param string $prenom_parent
     */
    public function setPrenomParent($prenom_parent) 
    {
        $this->prenom_parent = $prenom_parent;
    }
    
    /**
     * Returns domicile.
     * @return string
     */
    public function getDomicile() 
    {
        return $this->domicile;
    }
    /**
     * Sets domicile.
     * @param string $domicile
     */
    public function setDomicile($domicile) 
    {
        $this->domicile = $domicile;
    }
   
    /**
     * Returns telephone1.
     * @return int
     */
    public function getTelephone1() 
    {
        return $this->telephone1;
    }
    /**
     * Sets title.
     * @param int $telephone1
     */
    public function setTelephone1($telephone1) 
    {
        $this->telephone1 = $telephone1;
    }
    /**
     * Returns telephone2.
     * @return int
     */
    public function getTelephone2() 
    {
        return $this->telephone2;
    }
    /**
     * Sets telephone2.
     * @param int $telephone2
     */
    public function setTelephone2($telephone2) 
    {
        $this->telephone2 = $telephone2;
    }
    /**
     * Sets email parent.
     * @param string $email_parent
     */
    public function setEmailParent($email_parent) 
    {
        $this->email_parent = $email_parent;
    }
    /**
     * Returns email parent.
     * @return string
     */
    public function getEmailParent() 
    {
        return $this->email_parent;
    }
    
    /**
     * Sets comment.
     * @param string $commentaires
     */
    public function setCommentaires($commentaires) 
    {
        $this->commentaires = $commentaires;
    }
    /**
     * Returns comment.
     * @return string
     */
    public function getCommentaires() 
    {
        return $this->commentaires;
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
        $eleve->addContact($this);
    }
     
    
}