<?php

namespace Mii\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;


use Mii\GameBundle\Entity\Partida;
use Mii\GameBundle\Entity\Solution;

class EntradaController extends Controller
{
    /**
     * @Route("/index")
     */
    public function indexAction()
    {
        return $this->render('MiiGameBundle:Entrada:index.html.twig');
    }
    
    /**
     * @Route("/", name="levels")
     */
    public function facebookAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$easylevels = $em->getRepository('MiiGameBundle:Level')->findBy(Array('block'=>'first'));
    	$normallevels = $em->getRepository('MiiGameBundle:Level')->findBy(Array('block'=>'second'));
    	$hardlevels = $em->getRepository('MiiGameBundle:Level')->findBy(Array('block'=>'third'));

    	
    	
        return $this->render('MiiGameBundle:Entrada:facebook.html.twig', Array(
        	'easylevels' => $easylevels,
        	'normallevels' => $normallevels,
        	'hardlevels' => $hardlevels
        ));
    }
    
    /**
     * @Route("/play/{level}" , name="playlevel")
     */
    public function playLevelAction($level)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$level = $em->getRepository('MiiGameBundle:Level')->find($level);
    	
    	
        return $this->render('MiiGameBundle:Entrada:play.html.twig', Array(
        	'level' => $level
        ));
    }
    
    /**
     * @Route("/facebook/channel" , name="channel")
     */
    public function channelAction($level)
    {
    	
    	
        return $this->render('MiiGameBundle:Entrada:channel.html.twig', Array(
        ));
    }
    
     }
