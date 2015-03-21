<?php

namespace Crm\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SupAgent
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class SupUtilisateur
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateaffectation", type="datetime")
     */
    private $dateaffectation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datedesacffectation", type="datetime",nullable=true)
     */
    private $datedesacffectation;

    /**
     * @var boolean
     *
     * @ORM\Column(name="trash", type="boolean")
     */
    private $trash;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
    * @ORM\ManyToOne(targetEntity="Crm\AdminBundle\Entity\Utilisateur",cascade={"persist","remove"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $superviseur;

     /**
    * @ORM\ManyToOne(targetEntity="Crm\AdminBundle\Entity\Utilisateur",cascade={"persist","remove"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $utilisateur;

    /**
    * @ORM\ManyToOne(targetEntity="Crm\AdminBundle\Entity\Profil",cascade={"persist","remove"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $profil;

    public function __construct(){
        $this->dateaffectation = new \DateTime();
        $this->datedesacffectation = null;
        $this->active = true;
        $this->trash = false;
    }


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateaffectation
     *
     * @param \DateTime $dateaffectation
     * @return SupUtilisateur
     */
    public function setDateaffectation($dateaffectation)
    {
        $this->dateaffectation = $dateaffectation;

        return $this;
    }

    /**
     * Get dateaffectation
     *
     * @return \DateTime 
     */
    public function getDateaffectation()
    {
        return $this->dateaffectation;
    }

    /**
     * Set datedesacffectation
     *
     * @param \DateTime $datedesacffectation
     * @return SupUtilisateur
     */
    public function setDatedesacffectation($datedesacffectation)
    {
        $this->datedesacffectation = $datedesacffectation;

        return $this;
    }

    /**
     * Get datedesacffectation
     *
     * @return \DateTime 
     */
    public function getDatedesacffectation()
    {
        return $this->datedesacffectation;
    }

    /**
     * Set trash
     *
     * @param boolean $trash
     * @return SupUtilisateur
     */
    public function setTrash($trash)
    {
        $this->trash = $trash;

        return $this;
    }

    /**
     * Get trash
     *
     * @return boolean 
     */
    public function getTrash()
    {
        return $this->trash;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return SupUtilisateur
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set superviseur
     *
     * @param \Crm\AdminBundle\Entity\Utilisateur $superviseur
     * @return SupUtilisateur
     */
    public function setSuperviseur(\Crm\AdminBundle\Entity\Utilisateur $superviseur)
    {
        $this->superviseur = $superviseur;

        return $this;
    }

    /**
     * Get superviseur
     *
     * @return \Crm\AdminBundle\Entity\Utilisateur 
     */
    public function getSuperviseur()
    {
        return $this->superviseur;
    }

    /**
     * Set utilisateur
     *
     * @param \Crm\AdminBundle\Entity\Utilisateur $utilisateur
     * @return SupUtilisateur
     */
    public function setUtilisateur(\Crm\AdminBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \Crm\AdminBundle\Entity\Utilisateur 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set profil
     *
     * @param \Crm\AdminBundle\Entity\Profil $profil
     * @return SupUtilisateur
     */
    public function setProfil(\Crm\AdminBundle\Entity\Profil $profil)
    {
        $this->profil = $profil;

        return $this;
    }

    /**
     * Get profil
     *
     * @return \Crm\AdminBundle\Entity\Profil 
     */
    public function getProfil()
    {
        return $this->profil;
    }
}
