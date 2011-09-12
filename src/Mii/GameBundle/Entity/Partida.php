<?php
namespace Mii\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */
class Partida
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var datetime $start
     *
     * @ORM\Column(name="start", type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(name="slug", type="string")
     */
    private $slug;

    /**
     * @var integer $time1
     *
     * @ORM\Column(name="time1", type="integer")
     */
    private $time1;

    /**
     * @var integer $time2
     *
     * @ORM\Column(name="time2", type="integer")
     */
    private $time2;

    /**
     * @var integer $time3
     *
     * @ORM\Column(name="time3", type="integer")
     */
    private $time3;

    /**
     * @var integer $timeout
     *
     * @ORM\Column(name="timeout", type="integer")
     */
    private $timeout;


    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="partidas")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;
    

    /**
     * @ORM\ManyToOne(targetEntity="Level", inversedBy="partidas")
     * @ORM\JoinColumn(name="level_", referencedColumnName="id")
     */
    private $level;
    
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
     * Set start
     *
     * @param datetime $start
     */
    public function setStart($start)
    {
        $this->start = $start;
    }

    /**
     * Get start
     *
     * @return datetime 
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set time1
     *
     * @param integer $time1
     */
    public function setTime1($time1)
    {
        $this->time1 = $time1;
    }

    /**
     * Get time1
     *
     * @return integer 
     */
    public function getTime1()
    {
        return $this->time1;
    }

    /**
     * Set time2
     *
     * @param integer $time2
     */
    public function setTime2($time2)
    {
        $this->time2 = $time2;
    }

    /**
     * Get time2
     *
     * @return integer 
     */
    public function getTime2()
    {
        return $this->time2;
    }

    /**
     * Set time3
     *
     * @param integer $time3
     */
    public function setTime3($time3)
    {
        $this->time3 = $time3;
    }

    /**
     * Get time3
     *
     * @return integer 
     */
    public function getTime3()
    {
        return $this->time3;
    }

    /**
     * Set timeout
     *
     * @param integer $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    /**
     * Get timeout
     *
     * @return integer 
     */
    public function getTimeout()
    {
        return $this->timeout;
    }
    
    public function setSlug($slug){
    	$this->slug = $slug;
    }
    
    public function getSlug(){
    	return $this->slug;
    }
    public function setUser($user)
    {
    	$this->user = $user;
    }
    
    public function getUser(){
    	return $this->user;
    }
    public function setLevel($level){
    	$this->level = $level;
    }
    public function getLevel(){
    	return $this->level;
    }
}