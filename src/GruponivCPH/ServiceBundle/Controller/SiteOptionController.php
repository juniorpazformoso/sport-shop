<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\SiteOption;
use GruponivCPH\ServiceBundle\Form\SiteOptionType;

/**
 * SiteOption controller.
 *
 */
class SiteOptionController extends Controller
{

    /**
     * Lists all SiteOption entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:SiteOption')->findAll();

        return $this->render('ServiceBundle:SiteOption:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new SiteOption entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new SiteOption();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('siteoption_show', array('id' => $entity->getId())));
        }

        return $this->render('ServiceBundle:SiteOption:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a SiteOption entity.
     *
     * @param SiteOption $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SiteOption $entity)
    {
        $form = $this->createForm(new SiteOptionType(), $entity, array(
            'action' => $this->generateUrl('siteoption_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new SiteOption entity.
     *
     */
    public function newAction()
    {
        $entity = new SiteOption();
        $form   = $this->createCreateForm($entity);

        return $this->render('ServiceBundle:SiteOption:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a SiteOption entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:SiteOption')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SiteOption entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:SiteOption:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing SiteOption entity.
     *
     */
    public function editAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:SiteOption')->findAll()[0];

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SiteOption entity.');
        }

        $editForm = $this->createEditForm($entity);

        return $this->render('ServiceBundle:SiteOption:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a SiteOption entity.
    *
    * @param SiteOption $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(SiteOption $entity)
    {
        $form = $this->createForm(new SiteOptionType(), $entity, array(
            'action' => $this->generateUrl('siteoption_update'),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));

        return $form;
    }
    /**
     * Edits an existing SiteOption entity.
     *
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:SiteOption')->findAll()[0];

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find SiteOption entity.');
        }

        
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Configuración modificada satisfactoriamente');
            
            return $this->redirect($this->generateUrl('siteoption_edit'));
        }

        return $this->render('ServiceBundle:SiteOption:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }
    /**
     * Deletes a SiteOption entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:SiteOption')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find SiteOption entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('siteoption'));
    }

    /**
     * Creates a form to delete a SiteOption entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('siteoption_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
