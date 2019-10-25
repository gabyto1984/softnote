<?php
namespace Periodeval\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Periodeval\Entity\Periodeval;

/**
 * This class represents a single discipline.
 * @ORM\Entity(repositoryClass="\Periodeval\Repository\PdecisionnelleRepository")
 * @ORM\Table(name="soft_tbl_pdecisionnelle")
 */
class Pdecisionnelle 
{
    
    /**
     * @ORM\Id
     * @ORM\Column(name="id")
     * @ORM\GeneratedValue
     */
    protected $id;
    /** 
     * @ORM\Column(name="libele_periode")  
     */
    protected $libele_periode;
    
     /** 
     * @ORM\Column(name="type")  
     */
    protected $type; 
    
    // rang matiere.
    const TYPE_ORDINAIRE  = 0; // ORDINAIRE 
    const TYPE_DECISIONNEL  = 1; // BASE
    
  
     /**
     * @ORM\OneToMany(targetEntity="\Periodeval\Entity\Periodeval", mappedBy="pdecisionnelle")
     * @ORM\JoinColumn(name="id", referencedColumnName="id_pdecisionnelle")
     */
    protected $periodeval;
    
     /**
     * Constructor.
     */
    public function __construct() 
    {
        $this->periodeval = new ArrayCollection();               
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
    public function getLibelePeriode() 
    {
        return $this->libele_periode;
    }
    /**
     * Sets title.
     * @param string $libele_periode
     */
    public function setLibelePeriode($libele_periode) 
    {
        $this->libele_periode = $libele_periode;
    }
    
     /**
     * Returns sexe.
     * @return int     
     */
    public function getType() 
    {
        return $this->type;
    }

    /**
     * Returns possible sexe as array.
     * @return array
     */
    public static function getTypeList() 
    {
        return [
            self::TYPE_ORDINAIRE => 'ORDINAIRE',
            self::TYPE_DECISIONNEL => 'DECISIONNEL'
        ];
    }    
    
    /**
     * Returns  rang as string.
     * @return string
     */
    public function getTypeAsString()
    {
        $list = self::getTypeList();
        if (isset($list[$this->type]))
            return $list[$this->type];
        
        return 'Inconnu';
    }    
    
    /**
     * Sets .
     * @param int $type     
     */
    public function setType($type) 
    {
        $this->type = $type;
    } 
    
        
     /**
     * Returns comments for this eleve.
     * @return array
     */
    public function getPeriode() 
    {
        return $this->periodeval;
    }
    
    /**
     * Adds a new comment to this post.
     * @param $periodeval
     */
    public function addPeriode($periodeval) 
    {
        $this->periodeval[] = $periodeval;
    }
    
}
