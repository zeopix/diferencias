<?php

namespace Mii\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Mii\GameBundle\Entity\Solution
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Solution
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
     * @var string $xstart
     *
     * @ORM\Column(name="xstart", type="string", length=255)
     */
    private $xstart;

    /**
     * @var string $xend
     *
     * @ORM\Column(name="xend", type="string", length=255)
     */
    private $xend;

    /**
     * @var string $ystart
     *
     * @ORM\Column(name="ystart", type="string", length=255)
     */
    private $ystart;

    /**
     * @var string $yend
     *
     * @ORM\Column(name="yend", type="string", length=255)
     */
    private $yend;



    /**
     * @ORM\ManyToOne(targetEntity="Level", inversedBy="solutions")
     * @ORM\JoinColumn(name="level_id", referencedColumnName="id")
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
     * Set xstart
     *
     * @param string $xstart
     */
    public function setXstart($xstart)
    {
        $this->xstart = $xstart;
    }

    /**
     * Get xstart
     *
     * @return string 
     */
    public function getXstart()
    {
        return $this->xstart;
    }

    /**
     * Set xend
     *
     * @param string $xend
     */
    public function setXend($xend)
    {
        $this->xend = $xend;
    }

    /**
     * Get xend
     *
     * @return string 
     */
    public function getXend()
    {
        return $this->xend;
    }

    /**
     * Set ystart
     *
     * @param string $ystart
     */
    public function setYstart($ystart)
    {
        $this->ystart = $ystart;
    }

    /**
     * Get ystart
     *
     * @return string 
     */
    public function getYstart()
    {
        return $this->ystart;
    }

    /**
     * Set yend
     *
     * @param string $yend
     */
    public function setYend($yend)
    {
        $this->yend = $yend;
    }

    /**
     * Get yend
     *
     * @return string 
     */
    public function getYend()
    {
        return $this->yend;
    }
    
    public function getLevel(){
    	return $this->level;
    }
    
    public function setLevel($level){
    	$this->level = $level;
    }
}