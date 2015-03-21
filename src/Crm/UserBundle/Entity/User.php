<?php

namespace Crm\UserBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use FOS\MessageBundle\Model\ParticipantInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser  implements ParticipantInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
    * @ORM\OneToMany(targetEntity="Crm\AdminBundle\Entity\Log",mappedBy="user")
    * 
    */
    private $logs;

    /**
    * @ORM\OneToMany(targetEntity="Crm\AdminBundle\Entity\Notification",mappedBy="user")
    * 
    */
    private $notifications;

    public function __construct()
    {
        parent::__construct();
        // your own logic
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
     * Add logs
     *
     * @param \Crm\AdminBundle\Entity\Log $logs
     * @return User
     */
    public function addLog(\Crm\AdminBundle\Entity\Log $logs)
    {
        $this->logs[] = $logs;

        return $this;
    }

    /**
     * Remove logs
     *
     * @param \Crm\AdminBundle\Entity\Log $logs
     */
    public function removeLog(\Crm\AdminBundle\Entity\Log $logs)
    {
        $this->logs->removeElement($logs);
    }

    /**
     * Get logs
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Add notifications
     *
     * @param \Crm\AdminBundle\Entity\Notification $notifications
     * @return User
     */
    public function addNotification(\Crm\AdminBundle\Entity\Notification $notifications)
    {
        $this->notifications[] = $notifications;

        return $this;
    }

    /**
     * Remove notifications
     *
     * @param \Crm\AdminBundle\Entity\Notification $notifications
     */
    public function removeNotification(\Crm\AdminBundle\Entity\Notification $notifications)
    {
        $this->notifications->removeElement($notifications);
    }

    /**
     * Get notifications
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNotifications()
    {
        return $this->notifications;
    }
}
