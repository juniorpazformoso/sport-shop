<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\ZoneSend;
use GruponivCPH\ServiceBundle\Form\ZoneSenderType;

/**
 * ZoneSend controller.
 *
 */
class ZoneSendController extends Controller
{

    /**
     * Lists all FreeShippingZone entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:ZoneSend')->findAll();
        
        $aaData = array();
        foreach ($entities as $ent) {
            $delete_form = $this->createDeleteForm($ent->getId())->createView();
            $action = $this->renderView('ServiceBundle:ZoneSend:actions.html.twig', array('delete_form' => $delete_form, 'entity_id' => $ent->getId(), 'entity_name' => $ent->getZone()));

            $aaData[] = array(
                'action'  => $action
            );
        }

        return $this->render('ServiceBundle:ZoneSend:index.html.twig', array(
            'entities' => $entities,
            'aaData' => $aaData
        ));
    }
    /**
     * Creates a new FreeShippingZone entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ZoneSend();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('freeshippingzone'));
        }

        return $this->render('ServiceBundle:ZoneSend:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a FreeShippingZone entity.
     *
     * @param FreeShippingZone $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(ZoneSend $entity)
    {
        $form = $this->createForm(new ZoneSenderType(), $entity, array(
            'action' => $this->generateUrl('freeshippingzone_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new FreeShippingZone entity.
     *
     */
    public function newAction()
    {
        $entity = new ZoneSend();
        $form   = $this->createCreateForm($entity);

        return $this->render('ServiceBundle:ZoneSend:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FreeShippingZone entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:ZoneSend')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FreeShippingZone entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:ZoneSend:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing FreeShippingZone entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:ZoneSend')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FreeShippingZone entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:ZoneSend:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a FreeShippingZone entity.
    *
    * @param FreeShippingZone $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ZoneSend $entity)
    {
        $form = $this->createForm(new ZoneSenderType(), $entity, array(
            'action' => $this->generateUrl('freeshippingzone_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));

        return $form;
    }
    /**
     * Edits an existing FreeShippingZone entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:ZoneSend')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FreeShippingZone entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('freeshippingzone'));
        }

        return $this->render('ServiceBundle:ZoneSend:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a FreeShippingZone entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:ZoneSend')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FreeShippingZone entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('freeshippingzone'));
    }

    /**
     * Creates a form to delete a FreeShippingZone entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('freeshippingzone_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
