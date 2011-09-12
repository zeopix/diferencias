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
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('MiiGameBundle:Entrada:index.html.twig');
    }
    
    /**
     * @Route("/facebook/", name="levels")
     */
    public function facebookAction()
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$levels = $em->getRepository('MiiGameBundle:Level')->findAll();
    	
    	
        return $this->render('MiiGameBundle:Entrada:facebook.html.twig', Array(
        	'easylevels' => $levels,
        	'normallevels' => $levels,
        	'hardlevels' => $levels
        ));
    }
    
    /**
     * @Route("/facebook/play/{level}" , name="playlevel")
     */
    public function playLevelAction($level)
    {
    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$level = $em->getRepository('MiiGameBundle:Level')->find($level);
    	
    	
        return $this->render('MiiGameBundle:Entrada:play.html.twig', Array(
        	'level' => $level
        ));
    }
    
     }
