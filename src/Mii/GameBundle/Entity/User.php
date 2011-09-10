<?php
namespace Mii\GameBundle\Entity;

use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }
    
    /**
     * var string
     * @ORM\Column(name="firstname", type="string")
     */
    protected $firstname;

    /**
     * var string
     * @ORM\Column(name="lastname", type="string")
     */
    protected $lastname;

    /**
     * var string
     * @ORM\Column(name="facebookID", type="integer", length="60")
     */
    protected $facebookID;

    /**
     * return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * param string $firstname
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * param string $lastname
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;
    }

    /**
     * Get the full name of the user (first + last name)
     * return string
     */
    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastname();
    }

    /**
     * param string $facebookID
     * return void
     */
    public function setFacebookID($facebookID)
    {
        $this->facebookID = $facebookID;
        $this->setUsername($facebookID);
        $this->salt = '';
    }

    /**
     * return string
     */
    public function getFacebookID()
    {
        return $this->facebookID;
    }

    /**
     * @param Array
     */
    public function setFBData($fbdata)
    {
        if (isset($fbdata['id'])) {
            $this->setFacebookID($fbdata['id']);
            $this->addRole('ROLE_FACEBOOK');
        }
        if (isset($fbdata['first_name'])) {
            $this->setFirstname($fbdata['first_name']);
        }
        if (isset($fbdata['last_name'])) {
            $this->setLastname($fbdata['last_name']);
        }
        if (isset($fbdata['email'])) {
            $this->setEmail($fbdata['email']);
        }
    }
}