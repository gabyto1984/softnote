<?php
namespace Ecole\Entity;
use Doctrine\ORM\Mapping as ORM;
use Ecole\Entity\Ecole;

/**
 * This class represents a single salle.
 * @ORM\Entity(repositoryClass="\Ecole\Repository\EcoleRepository")
 * @ORM\Table(name="soft_tbl_ecole_2")
 */
class Ecole 
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
    protected $nom;
    
    /** 
     * @ORM\Column(name="adresse")  
     */
    protected $adresse;
    
    /** 
     * @ORM\Column(name="email")  
     */
    protected $email;
    
    /** 
     * @ORM\Column(name="telephones")  
     */
    protected $telephones;
    
    /** 
     * @ORM\Column(name="logo")  
     */
    protected $logo;
   
    
    public function getId() 
    {
        return $this->id;
    }
    /**
     * Sets ID of this ecole.
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
    public function getNom() 
    {
        return $this->nom;
    }
    /**
     * Sets title.
     * @param string $nom
     */
    public function setNom($nom) 
    {
        $this->nom = $nom;
    }
    /**
     * Returns probleme.
     * @return string
     */
    public function getAdresse() 
    {
        return $this->adresse;
    }
    /**
     * Sets title.
     * @param string $adresse
     */
    public function setAdresse($adresse) 
    {
        $this->adresse = $adresse;
    }
    
    /**
     * Returns email.
     * @return string
     */
    public function getEmail() 
    {
        return $this->email;
    }
    /**
     * Sets title.
     * @param string $email
     */
    public function setEmail($email) 
    {
        $this->email = $email;
    }
    
    /**
     * Returns email.
     * @return string
     */
    public function getTelephones() 
    {
        return $this->telephones;
    }
    /**
     * Sets title.
     * @param string $telephones
     */
    public function setTelephones($telephones) 
    {
        $this->telephones = $telephones;
    }
    
     /**
     * Returns email.
     * @return string
     */
    public function getLogo() 
    {
        return $this->logo;
    }
    /**
     * Sets title.
     * @param string $logo
     */
    public function setLogo($logo) 
    {
        $this->logo = $logo;
    }
    
    
}
