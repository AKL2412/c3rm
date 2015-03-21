<?php

namespace Crm\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuthFail
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Log
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
     * @ORM\Column(name="connectedat", type="datetime")
     */
    private $connectedat;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="deconnectedat", type="datetime",nullable=true)
     */
    private $deconnectedat;

    /**
     * @var boolean
     *
     * @ORM\Column(name="connected", type="boolean")
     */
    private $connected;

    /**
    * @ORM\ManyToOne(targetEntity="Crm\UserBundle\Entity\User",cascade={"remove", "persist"})
    * @ORM\JoinColumn(nullable=false)
    */
    private $user;

    public function __construct(){
        $this->connectedat = new \DateTime();
        $this->deconnectedat = null;
        $this->connected = true;
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
     * Set dateajout
     *
     * @param \DateTime $dateajout
     * @return Log
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
     * Set user
     *
     * @param \Crm\UserBundle\Entity\User $user
     * @return Log
     */
    public function setUser(\Crm\UserBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Crm\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set connectedat
     *
     * @param \DateTime $connectedat
     * @return Log
     */
    public function setConnectedat($connectedat)
    {
        $this->connectedat = $connectedat;

        return $this;
    }

    /**
     * Get connectedat
     *
     * @return \DateTime 
     */
    public function getConnectedat()
    {
        return $this->connectedat;
    }

    /**
     * Set deconnectedat
     *
     * @param \DateTime $deconnectedat
     * @return Log
     */
    public function setDeconnectedat($deconnectedat)
    {
        $this->deconnectedat = $deconnectedat;

        return $this;
    }

    /**
     * Get deconnectedat
     *
     * @return \DateTime 
     */
    public function getDeconnectedat()
    {
        return $this->deconnectedat;
    }

    /**
     * Set connected
     *
     * @param boolean $connected
     * @return Log
     */
    public function setConnected($connected)
    {
        $this->connected = $connected;

        return $this;
    }

    /**
     * Get connected
     *
     * @return boolean 
     */
    public function getConnected()
    {
        return $this->connected;
    }
}
