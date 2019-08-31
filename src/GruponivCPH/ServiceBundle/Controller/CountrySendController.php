<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\FreeShippingCountry;
use GruponivCPH\ServiceBundle\Form\FreeShippingCountryType;

/**
 * CountrySendController controller.
 *
 */
class CountrySendController extends Controller
{

    /**
     * Lists all CountrySendController entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:CountrySend')->findAll();

        $aaData = array();
        foreach ($entities as $ent) {
            $delete_form = $this->createDeleteForm($ent->getId())->createView();
            $action = $this->renderView('ServiceBundle:CountrySend:actions.html.twig', array('delete_form' => $delete_form, 'entity_id' => $ent->getId(), 'entity_name' => $ent->getCountry()));

            $aaData[] = array(
                'action'  => $action
            );
        }
        
        return $this->render('ServiceBundle:CountrySend:index.html.twig', array(
            'entities' => $entities,
            'aaData' => $aaData
        ));
    }
    /**
     * Creates a new FreeShippingCountry entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new \GruponivCPH\ServiceBundle\Entity\CountrySend();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('freeshippingcountry'));
        }

        return $this->render('ServiceBundle:CountrySend:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a FreeShippingCountry entity.
     *
     * @param FreeShippingCountry $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(\GruponivCPH\ServiceBundle\Entity\CountrySend $entity)
    {
        $form = $this->createForm(new \GruponivCPH\ServiceBundle\Form\CountrySenderType(), $entity, array(
            'action' => $this->generateUrl('freeshippingcountry_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new FreeShippingCountry entity.
     *
     */
    public function newAction()
    {
        $entity = new \GruponivCPH\ServiceBundle\Entity\CountrySend();
        $form   = $this->createCreateForm($entity);

        return $this->render('ServiceBundle:CountrySend:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a FreeShippingCountry entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:CountrySend')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FreeShippingCountry entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:CountrySend:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CountrySend entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:CountrySend')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CountrySend entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:CountrySend:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a FreeShippingCountry entity.
    *
    * @param FreeShippingCountry $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(\GruponivCPH\ServiceBundle\Entity\CountrySend $entity)
    {
        $form = $this->createForm(new \GruponivCPH\ServiceBundle\Form\CountrySenderType(), $entity, array(
            'action' => $this->generateUrl('freeshippingcountry_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));

        return $form;
    }
    /**
     * Edits an existing FreeShippingCountry entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:CountrySend')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find FreeShippingCountry entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('freeshippingcountry'));
        }

        return $this->render('ServiceBundle:CountrySend:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a FreeShippingCountry entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:CountrySend')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find FreeShippingCountry entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('freeshippingcountry'));
    }

    /**
     * Creates a form to delete a FreeShippingCountry entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('freeshippingcountry_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
