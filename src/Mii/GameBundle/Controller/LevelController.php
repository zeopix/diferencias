<?php

namespace Mii\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Mii\GameBundle\Entity\Level;
use Mii\GameBundle\Form\LevelType;

use Symfony\Component\HttpFoundation\Response;

use Mii\GameBundle\Entity\Solution;
use Mii\GameBundle\Entity\Partida;

/**
 * Level controller.
 *
 * @Route("/level")
 */
class LevelController extends Controller
{
    /**
     * Lists all Level entities.
     *
     * @Route("/", name="level")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entities = $em->getRepository('MiiGameBundle:Level')->findAll();

        return array('entities' => $entities);
    }

    /**
     * Finds and displays a Level entity.
     *
     * @Route("/{id}/show", name="level_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('MiiGameBundle:Level')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Level entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Finds and displays a Level entity.
     *
     * @Route("/{id}/solution/add", name="addsolution")
     * @Template()
     */
    public function addSolutionAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

		$request = $this->getRequest()->request;
		
        $entity = $em->getRepository('MiiGameBundle:Level')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Level entity.');
        }
        
        $radius = 5;
        $x_center = $request->get('xcenter');
        $y_center = $request->get('ycenter');
        
        $solution = new Solution();
        
        $solution->setLevel($entity);
        $solution->setXstart($x_center-$radius);
        $solution->setXend($x_center+$radius);
        $solution->setYstart($y_center-$radius);
        $solution->setYend($y_center+$radius);
        
        $em->persist($solution);
        $em->flush();
        
        $response = Array(
        	'status' => "success",
        	'entity' => Array(
        		'xcenter' => $x_center,
        		'ycenter' => $y_center
        	)
        );

        return new Response(json_encode($response));
    }

   

    /**
     * Finds and displays a Level entity.
     *
     * @Route("/solution/{id}/remove", name="removesolution")
     * @Template()
     */
    public function removeSolutionAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();
		
        $entity = $em->getRepository('MiiGameBundle:Solution')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Level entity.');
        }
        $level = $entity->getLevel()->getId();
        
        
        $em->remove($entity);
        $em->flush();
        
        $response = Array(
        	'status' => "success"
        );

        return $this->redirect($this->generateUrl('level_edit', Array('id' => $level)));
    }
    

    /**
     * Displays a form to create a new Level entity.
     *
     * @Route("/new", name="level_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Level();
        $form   = $this->createForm(new LevelType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Level entity.
     *
     * @Route("/create", name="level_create")
     * @Method("post")
     * @Template("MiiGameBundle:Level:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Level();
        $request = $this->getRequest();
        $form    = $this->createForm(new LevelType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('level_show', array('id' => $entity->getId())));
            
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Level entity.
     *
     * @Route("/{id}/edit", name="level_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('MiiGameBundle:Level')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Level entity.');
        }

        $editForm = $this->createForm(new LevelType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Level entity.
     *
     * @Route("/{id}/update", name="level_update")
     * @Method("post")
     * @Template("MiiGameBundle:Level:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('MiiGameBundle:Level')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Level entity.');
        }

        $editForm   = $this->createForm(new LevelType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('level_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Level entity.
     *
     * @Route("/{id}/delete", name="level_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('MiiGameBundle:Level')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Level entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('level'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
