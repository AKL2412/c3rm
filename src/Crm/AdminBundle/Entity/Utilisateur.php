<?php

namespace Crm\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Utilisateur
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Utilisateur
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255,unique=true)
     */
    private $email;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="ddn", type="date")
     */
    private $ddn;

    /**
     * @var string
     *
     * @ORM\Column(name="presentation", type="text")
     */
    private $presentation;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="tel", type="string", length=255)
     */
    private $tel;
     /**
     * @var string
     *
     * @ORM\Column(name="cin", type="string", length=50)
     */
    private $cin;
    /**
     * @var string
     *
     * @ORM\Column(name="motpasse", type="string", length=255,nullable=true)
     */
    private $motpasse;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateajout", type="datetime")
     */
    private $dateajout;
     /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;
     /**
     * @var boolean
     *
     * @ORM\Column(name="trash", type="boolean")
     */
    private $trash;
    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="text",nullable=true)
     */
    private $adresse;
    /**
    * @ORM\ManyToOne(targetEntity="Crm\AdminBundle\Entity\Genre")
    * @ORM\JoinColumn(nullable=true)
    */
    private $genre;

    /*------------ RELATION COMMUNES A TOUS ------------------------*/
    /**
    * @ORM\OneToOne(targetEntity="Crm\UserBundle\Entity\User",cascade={"remove", "persist"})
    * @ORM\JoinColumn(nullable=true)
    */
    private $compte;
    /**
    * @ORM\ManyToOne(targetEntity="Crm\AdminBundle\Entity\Profil",cascade={"persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $profil;


    /*============= FIN RELATIONS COMMUNES ======================*/

    /*------------ RELATION D'UN AGENT  ------------------------*/

        // Ses superviseurs 
    /**
    * @ORM\OneToMany(targetEntity="Crm\AdminBundle\Entity\SupUtilisateur",mappedBy="utilisateur")
    */
    private $mesSups;
    /*============= FIN RELATIONS D'UN AGENT ======================*/

     /*------------ RELATION D'UN CONFIRMATEUR  ------------------------*/
     // Ses confirmateurs 
    
    /*============= FIN RELATIONS D'UN CONFIRMATEUR ======================*/

    /*------------ RELATION D'UN SUPERVISEUR  ------------------------*/
    // Ses agents 
    /**
    * @ORM\OneToMany(targetEntity="Crm\AdminBundle\Entity\SupUtilisateur",mappedBy="superviseur")
    */
    private $supUtilisateurs;
    
    /*============= FIN RELATIONS D'UN SUPERVISEUR ======================*/
    public function __construct(){
        $this->dateajout = new \Datetime();
        $this->image = "default.png";
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
     * Set nom
     *
     * @param string $nom
     * @return Utilisateur
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string 
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     * @return Utilisateur
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Utilisateur
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set ddn
     *
     * @param \DateTime $ddn
     * @return Utilisateur
     */
    public function setDdn($ddn)
    {
        $this->ddn = $ddn;

        return $this;
    }

    /**
     * Get ddn
     *
     * @return \DateTime 
     */
    public function getDdn()
    {
        return $this->ddn;
    }

    /**
     * Set presentation
     *
     * @param string $presentation
     * @return Utilisateur
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * Get presentation
     *
     * @return string 
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Utilisateur
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set tel
     *
     * @param string $tel
     * @return Utilisateur
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get tel
     *
     * @return string 
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set cin
     *
     * @param string $cin
     * @return Utilisateur
     */
    public function setCin($cin)
    {
        $this->cin = $cin;

        return $this;
    }

    /**
     * Get cin
     *
     * @return string 
     */
    public function getCin()
    {
        return $this->cin;
    }

    /**
     * Set motpasse
     *
     * @param string $motpasse
     * @return Utilisateur
     */
    public function setMotpasse($motpasse)
    {
        $this->motpasse = $motpasse;

        return $this;
    }

    /**
     * Get motpasse
     *
     * @return string 
     */
    public function getMotpasse()
    {
        return $this->motpasse;
    }

    /**
     * Set dateajout
     *
     * @param \DateTime $dateajout
     * @return Utilisateur
     */
    public function setDateajout($dateajout)
    {
        $this->dateajout = $dateajout;

        return $this;
    }

    /**
     * Get dateajout
     *
     * @return \DateTime 
     */
    public function getDateajout()
    {
        return $this->dateajout;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Utilisateur
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
     * Set trash
     *
     * @param boolean $trash
     * @return Utilisateur
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
     * Set adresse
     *
     * @param string $adresse
     * @return Utilisateur
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string 
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set compte
     *
     * @param \Crm\UserBundle\Entity\User $compte
     * @return Utilisateur
     */
    public function setCompte(\Crm\UserBundle\Entity\User $compte = null)
    {
        $this->compte = $compte;

        return $this;
    }

    /**
     * Get compte
     *
     * @return \Crm\UserBundle\Entity\User 
     */
    public function getCompte()
    {
        return $this->compte;
    }

    /**
     * Set profil
     *
     * @param \Crm\AdminBundle\Entity\Profil $profil
     * @return Utilisateur
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

    /**
     * Add mesSups
     *
     * @param \Crm\AdminBundle\Entity\SupUtilisateur $mesSups
     * @return Utilisateur
     */
    public function addMesSup(\Crm\AdminBundle\Entity\SupUtilisateur $mesSups)
    {
        $this->mesSups[] = $mesSups;

        return $this;
    }

    /**
     * Remove mesSups
     *
     * @param \Crm\AdminBundle\Entity\SupUtilisateur $mesSups
     */
    public function removeMesSup(\Crm\AdminBundle\Entity\SupUtilisateur $mesSups)
    {
        $this->mesSups->removeElement($mesSups);
    }

    /**
     * Get mesSups
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getMesSups()
    {
        return $this->mesSups;
    }

    /**
     * Add supUtilisateurs
     *
     * @param \Crm\AdminBundle\Entity\SupUtilisateur $supUtilisateurs
     * @return Utilisateur
     */
    public function addSupUtilisateur(\Crm\AdminBundle\Entity\SupUtilisateur $supUtilisateurs)
    {
        $this->supUtilisateurs[] = $supUtilisateurs;

        return $this;
    }

    /**
     * Remove supUtilisateurs
     *
     * @param \Crm\AdminBundle\Entity\SupUtilisateur $supUtilisateurs
     */
    public function removeSupUtilisateur(\Crm\AdminBundle\Entity\SupUtilisateur $supUtilisateurs)
    {
        $this->supUtilisateurs->removeElement($supUtilisateurs);
    }

    /**
     * Get supUtilisateurs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSupUtilisateurs()
    {
        return $this->supUtilisateurs;
    }

    /**
     * Set genre
     *
     * @param \Crm\AdminBundle\Entity\Genre $genre
     * @return Utilisateur
     */
    public function setGenre(\Crm\AdminBundle\Entity\Genre $genre = null)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return \Crm\AdminBundle\Entity\Genre 
     */
    public function getGenre()
    {
        return $this->genre;
    }
}
