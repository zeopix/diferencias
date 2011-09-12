<?php

namespace Mii\GameBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mii\GameBundle\Entity\Level
 *
 * @ORM\Table()
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Level
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
     * @var string $block
     *
     * @ORM\Column(name="block", type="string", length=255)
     */
    private $block;

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
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;
    
    
    /**
     * @var string $title
     *
     * @ORM\OneToMany(targetEntity="Partida", mappedBy="level")
     */
    private $partidas;


    /**
     * @var string $title
     *
     * @ORM\OneToMany(targetEntity="Solution", mappedBy="level")
     */
    private $solutions;

    /**
     * @Assert\File(maxSize="6000000")
     */
    public $file;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $path;




    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->file) {
            // do whatever you want to generate a unique name
            $this->setPath(uniqid().'.'.$this->file->guessExtension());
        }
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->file) {
            return;
        }

        // you must throw an exception here if the file cannot be moved
        // so that the entity is not persisted to the database
        // which the UploadedFile move() method does automatically
        $this->file->move($this->getUploadRootDir(), $this->path);

        unset($this->file);
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        if ($file = $this->getAbsolutePath()) {
            unlink($file);
        }
    }


    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir().'/'.$this->path;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw when displaying uploaded doc/image in the view.
        return 'uploads/documents';
    }
    
    
    public function __construct() {
        $this->solutions = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set block
     *
     * @param string $block
     */
    public function setBlock($block)
    {
        $this->block = $block;
    }

    /**
     * Get block
     *
     * @return string 
     */
    public function getBlock()
    {
        return $this->block;
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

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    public function setPath($path){
    	$this->path = $path;
    }
    
    public function getPath(){
    	return $this->path;
    }
    
    public function getSolutions(){
    	return $this->solutions;
    }
    
    public function countSolutions(){
    	return count($this->solutions);
    }
    
    public function countPartidas(){
    	return count($this->partidas);
    }
}