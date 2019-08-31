<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\Zone;
use GruponivCPH\ServiceBundle\Form\ZoneType;

/**
 * Zone controller.
 *
 */
class ZoneController extends Controller
{

    /**
     * Lists all Zone entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:Zone')->findAll();
        
        $aaData = array();
        foreach ($entities as $ent) {
            $delete_form = $this->createDeleteForm($ent->getId())->createView();
            $action = $this->renderView('ServiceBundle:Zone:actions.html.twig', array('delete_form' => $delete_form, 'entity_id' => $ent->getId(), 'entity_name' => $ent->getName()));

            $aaData[] = array(
                'action'  => $action
            );
        }

        return $this->render('ServiceBundle:Zone:index.html.twig', array(
            'entities' => $entities,
            'aaData' => $aaData
        ));
    }
    /**
     * Creates a new Zone entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Zone();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl('zone'));
        }

        return $this->render('ServiceBundle:Zone:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Zone entity.
     *
     * @param Zone $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(\GruponivCPH\ServiceBundle\Entity\ZoneSend $entity)
    {
        $form = $this->createForm(new \GruponivCPH\ServiceBundle\Form\ZoneSenderType(), $entity, array(
            'action' => $this->generateUrl('zone_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Zone entity.
     *
     */
    public function newAction()
    {
        $entity = new Zone();
        $form   = $this->createCreateForm($entity);

        return $this->render('ServiceBundle:Zone:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Zone entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Zone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Zone entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:Zone:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Zone entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Zone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Zone entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:Zone:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Zone entity.
    *
    * @param Zone $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(\GruponivCPH\ServiceBundle\Entity\ZoneSend $entity)
    {
        $form = $this->createForm(new \GruponivCPH\ServiceBundle\Form\ZoneSenderType(), $entity, array(
            'action' => $this->generateUrl('zone_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));

        return $form;
    }
    /**
     * Edits an existing Zone entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Zone')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Zone entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('zone'));
        }

        return $this->render('ServiceBundle:Zone:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Zone entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:Zone')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Zone entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('zone'));
    }

    /**
     * Creates a form to delete a Zone entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('zone_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
