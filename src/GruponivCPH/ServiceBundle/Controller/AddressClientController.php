<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\AddressClient;
use GruponivCPH\ServiceBundle\Form\AddressClientType;

/**
 * AddressClient controller.
 *
 */
class AddressClientController extends Controller
{

    /**
     * Lists all AddressClient entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:AddressClient')->findAll();
         
        $aaData = array();
        foreach ($entities as $ent) {
            $delete_form = $this->createDeleteForm($ent->getId())->createView();
            $action = $this->renderView('ServiceBundle:AddressClient:actions.html.twig', array('delete_form' => $delete_form, 'entity_id' => $ent->getId(), 'entity_name' => $ent->getId()));

            $aaData[] = array(
                'action'  => $action
            );
        }

        return $this->render('ServiceBundle:AddressClient:index.html.twig', array(
            'entities' => $entities,
            'aaData' => $aaData
        ));
    }
    
    
    /**
     * Creates a new AddressClient entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new AddressClient();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('addressclient'));
        }

        return $this->render('ServiceBundle:AddressClient:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a AddressClient entity.
     *
     * @param AddressClient $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AddressClient $entity)
    {
        $form = $this->createForm(new AddressClientType(), $entity, array(
            'action' => $this->generateUrl('addressclient_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new AddressClient entity.
     *
     */
    public function newAction()
    {
        $entity = new AddressClient();
        $form   = $this->createCreateForm($entity);

        return $this->render('ServiceBundle:AddressClient:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AddressClient entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:AddressClient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AddressClient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:AddressClient:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AddressClient entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:AddressClient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AddressClient entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:AddressClient:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a AddressClient entity.
    *
    * @param AddressClient $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AddressClient $entity)
    {
        $form = $this->createForm(new AddressClientType(), $entity, array(
            'action' => $this->generateUrl('addressclient_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));

        return $form;
    }
    /**
     * Edits an existing AddressClient entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:AddressClient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AddressClient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('addressclient'));
        }

        return $this->render('ServiceBundle:AddressClient:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a AddressClient entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:AddressClient')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AddressClient entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('addressclient'));
    }

    /**
     * Creates a form to delete a AddressClient entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('addressclient_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
