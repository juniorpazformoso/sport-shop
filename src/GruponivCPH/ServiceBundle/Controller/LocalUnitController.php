<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\LocalUnit;
use GruponivCPH\ServiceBundle\Form\LocalUnitType;

/**
 * LocalUnit controller.
 *
 */
class LocalUnitController extends Controller
{

    /**
     * Lists all LocalUnit entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:LocalUnit')->findAll();

        return $this->render('ServiceBundle:LocalUnit:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new LocalUnit entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new LocalUnit();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('localunit_show', array('id' => $entity->getId())));
        }

        return $this->render('ServiceBundle:LocalUnit:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a LocalUnit entity.
     *
     * @param LocalUnit $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(LocalUnit $entity)
    {
        $form = $this->createForm(new LocalUnitType(), $entity, array(
            'action' => $this->generateUrl('localunit_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new LocalUnit entity.
     *
     */
    public function newAction()
    {
        $entity = new LocalUnit();
        $form   = $this->createCreateForm($entity);

        return $this->render('ServiceBundle:LocalUnit:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a LocalUnit entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:LocalUnit')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LocalUnit entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:LocalUnit:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing LocalUnit entity.
     *
     */
    public function editAction()
    {
        $em = $this->getDoctrine()->getManager();

        
        $entity = $em->getRepository('ServiceBundle:LocalUnit')->findAll()[0];

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LocalUnit entity.');
        }

        $editForm = $this->createEditForm($entity);
        

        return $this->render('ServiceBundle:LocalUnit:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a LocalUnit entity.
    *
    * @param LocalUnit $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(LocalUnit $entity)
    {
        $form = $this->createForm(new LocalUnitType(), $entity, array(
            'action' => $this->generateUrl('localunit_update'),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));

        return $form;
    }
    /**
     * Edits an existing LocalUnit entity.
     *
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:LocalUnit')->findAll()[0];

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find LocalUnit entity.');
        }

        
        
        
        
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            $this->get('session')->getFlashBag()->add('notice', 'Unidades locales modificadas');
            $em->flush();

            return $this->redirect($this->generateUrl('localunit_edit'));
        }

        return $this->render('ServiceBundle:LocalUnit:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a LocalUnit entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:LocalUnit')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find LocalUnit entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('localunit'));
    }

    /**
     * Creates a form to delete a LocalUnit entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('localunit_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
