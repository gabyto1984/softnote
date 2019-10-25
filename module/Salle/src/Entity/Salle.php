<?php
namespace Salle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Classe\Entity\Classe;

/**
 * This class represents a single salle.
 * @ORM\Entity(repositoryClass="\Salle\Repository\SalleRepository")
 * @ORM\Table(name="soft_tbl_salle_2")
 */
class Salle 
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
     * @ORM\Column(name="numero")  
     */
    protected $numero;
    
    /** 
     * @ORM\Column(name="quantite")  
     */
    protected $quantite;
    
    /**
     * Many features have one product. This is the owning side.
     * @ORM\ManyToOne(targetEntity="\Classe\Entity\Classe", inversedBy="salles")
     * @ORM\JoinColumn(name="id_classe", referencedColumnName="id")
     */
    protected $classe;
    
    
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
     * Returns numero.
     * @return int
     */
    public function getNumero() 
    {
        return $this->numero;
    }
    /**
     * Sets title.
     * @param int $numero
     */
    public function setNumero($numero) 
    {
        $this->numero = $numero;
    }
    /**
     * Returns process.
     * @return int
     */
    public function getQuantite() 
    {
        return $this->quantite;
    }
    /**
     * Returns process.
     * @param int $quantite
     */
    public function setQuantite($quantite) 
    {
        $this->quantite = $quantite;
    }
    
    /**
     * Returns tags for this post.
     * @return array
     */
    public function getClasse() 
    {
        return $this->classe;
    }      
    
    /**
     * Adds a new tag to this post.
     * @param $classe
     *      */
    public function addClasse(Classe $classe = null) 
    {
        $this->classe = $classe; 
    }
    
    
    
}
