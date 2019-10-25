<?php
namespace Eleve\Service;
use Zend\ServiceManager\ServiceManager;
use Zend\ServiceManager\ServiceManagerAwareInterface;
use Eleve\Entity\Eleve;
use Eleve\Entity\Contact;
use Zend\Filter\StaticFilter;

/**
 * Ce service Elevemanager servira pour ajouter, modifier, supprimer un eleve
 */
class EleveManager
{
    /**
     * Entity manager.
     * @var Doctrine\ORM\EntityManager;
     */
    private $entityManager;
    
    /**
     * Constructor.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    /**
     * This method adds a new post.
     */
    public function addNewEleve($data, $dataPath) 
    {
        // Creer un noubveau Eleve.
        $eleve = new Eleve();
        $eleve->setNomEleve($data['nom_eleve']);
        $eleve->setPrenomEleve($data['prenom_eleve']);
        $eleve->setDateNaissance($data['date_naissance']);
        $eleve->setLieuNaissance($data['lieu_naissance']);
        $eleve->setSexe($data['sexe']);
        $initial_code_eleve = substr($data['nom_eleve'], 0, 2).''.substr($data['prenom_eleve'], 0, 2);
        $code_eleve = strtoupper($initial_code_eleve.substr(sha1("--Hello world--".time()),0,10));
        $eleve->setCodeEleve($code_eleve);
        $eleve->setStatus($data['statut']);
        $eleve->setEMail($data['email']);
        $eleve->setPhotoEleve($dataPath);
        // Add the entity to entity manager.
        $this->entityManager->persist($eleve);  
       
        $this->entityManager->flush();
    }
    
    public function updateEleve($eleve, $data, $dataPath) 
    {
        $eleve->setNomEleve($data['nom_eleve']);
        $eleve->setPrenomEleve($data['prenom_eleve']);
        $eleve->setDateNaissance($data['date_naissance']);
        $eleve->setLieuNaissance($data['lieu_naissance']);
        $eleve->setSexe($data['sexe']);
        $eleve->setCodeEleve($data['code_eleve']);
        $eleve->setStatus($data['statut']);
        $eleve->setEMail($data['email']);
        $eleve->setPhotoEleve($dataPath);
        // Apply changes to database.
        $this->entityManager->flush();
    }
    
    /**
     * Removes eleve.
     */
    public function deleteEleve($eleve)          
    {
        $contacts = $eleve->getContacts();
        foreach($contacts as $contact){
            $this->entityManager->remove($contact);
        }
        $this->entityManager->remove($eleve);
        $this->entityManager->flush();
    }
    
    /**
     * This method adds a new contact to eleve.
     */
    public function addContactToEleve($eleve, $data) 
    {
        // Create new ContactParental entity.
        $contact = new Contact();
        $contact->setEleve($eleve);
        $contact->setNomParent($data['nom_parent']);
        $contact->setPrenomParent($data['prenom_parent']);
        $contact->setDomicile($data['domicile']);        
        $contact->setTelephone1($data['telephone1']);
        $contact->setTelephone2($data['telephone2']);
        $contact->setEmailParent($data['email_parent']);
        $contact->setCommentaires($data['commentaire']);
      
        // Add the entity to entity manager.
        $this->entityManager->persist($contact);

        // Apply changes.
        $this->entityManager->flush();
    }
    
}
