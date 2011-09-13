<?php

namespace Mii\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Symfony\Component\HttpFoundation\Response;


use Mii\GameBundle\Entity\Partida;
use Mii\GameBundle\Entity\Solution;

class PartidaController extends Controller
{
    
    /**
     * @Route("/play/{level}/start" , name="startlevel")
     */
    public function startLevelAction($level)
    {
    	$session = $this->getRequest()->getSession();

    	$em = $this->getDoctrine()->getEntityManager();
    	
    	$user = $this->get('security.context')->getToken()->getUser();
    	$level = $em->getRepository('MiiGameBundle:Level')->find($level);
    	
    	$partida = new Partida();
    	$partida->setSlug(uniqid());
    	$partida->setStart(new \DateTime());
    	$partida->setTime1(0);
    	$partida->setTime2(0);
    	$partida->setTime3(0);
    	$partida->setLevel($level);
    	
    	//die($user);
    	$partida->setUser($user);
    	
    	$partida->setTimeout(0);
    	//$partida->setUser();
    	
    	$em->persist($partida);
    	$em->flush();
 		
 		$session->set('partida', Array(
			'slug' => $partida->getSlug(), 
			'solved' => Array() 
		));
		   	
    	$response = Array(
    		'status' => 'success',
    		'partida' => Array(
    			'id' => $partida->getId(),
    			'slug' => $partida->getSlug(),
    		)
    	);
    	
        return new Response(json_encode($response));
    }
    
     /**
     * Finds and displays a Level entity.
     *
     * @Route("/partida/click", name="trysolution")
     */
    public function trySolutionAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

		$request = $this->getRequest()->request;
		
		$id = $request->get('id');
		
		$partida = $em->getRepository('MiiGameBundle:Partida')->findOneBySlug($id);
		
		
    	$session = $this->getRequest()->getSession();
    	
    	$partidasession = $session->get('partida');
    	
		if(!$partida){
			return new Response("error inesperado! " . $id . ";");
		}
		
        $xcenter = $request->get('xcenter');
        $ycenter = $request->get('ycenter');
                
        $solutions = $em->createQuery('SELECT s FROM MiiGameBundle:Solution s WHERE s.xstart < :xcenter AND s.xend > :xcenter AND s.ystart < :ycenter AND s.yend > :ycenter')->setParameter('xcenter',$xcenter)->setParameter('ycenter',$ycenter)->getResult();

        if ($solutions) {

			
			$solution = $solutions[0];
			$sid = $solution->getId();
			if(!in_array($sid,$partidasession['solved'])){
			
			$partidasession['solved'][] = $sid;
			$session->set('partida',$partidasession);
			
			$start = $partida->getStart();
			$now = new \DateTime();
			$tdiff = $now->diff($start);
			$diff = $tdiff->format("%s");

			$end = false;
			
			$left = 3;
			if(!($partida->getTime1() > 0)){
				$partida->setTime1($diff);
				$left = 2;
			}else if(!($partida->getTime2() > 0)){
				$partida->setTime2($diff);
				$left = 1;
			}else if(!($partida->getTime3() > 0)){
				$partida->setTime3($diff);
				$left = 0;
				$end = true;
				
				//$user->addSolved($partida->getLevel()->getId());
				
			}			
			
			$response = Array(
				'status' => 'success',
				'diff' => $diff,
				'end' => $end,
				'left' => $left,
				'solution' => Array(
					'status' => true,
					'xstart' => $solution->getXstart(),
					'ystart' => $solution->getYstart()
				)
			);
	
			}
			
        }else{
        	$response = Array(
        		'status' => 'fail'
        	);
        }
        
       
        //$em->persist($user);
        $em->persist($partida);
        $em->flush();

        return new Response(json_encode($response));
    }
}
