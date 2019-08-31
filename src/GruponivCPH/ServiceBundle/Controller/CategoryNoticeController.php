<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\CategoryNotice;
use GruponivCPH\ServiceBundle\Form\CategoryNoticeType;

/**
 * CategoryNotice controller.
 *
 */
class CategoryNoticeController extends Controller
{

    /**
     * Lists all CategoryNotice entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:CategoryNotice')->findAll();
        
        $aaData = array();
        foreach ($entities as $ent) {
            $delete_form = $this->createDeleteForm($ent->getId())->createView();
            $action = $this->renderView('ServiceBundle:CategoryNotice:actions.html.twig', array('delete_form' => $delete_form, 'entity_id' => $ent->getId(), 'entity_name' => $ent->getTitle()));

            $aaData[] = array(
                'action'  => $action
            );
        }

        return $this->render('ServiceBundle:CategoryNotice:index.html.twig', array(
            'entities' => $entities,
            'aaData' => $aaData,
        ));
    }
    /**
     * Creates a new CategoryNotice entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new CategoryNotice();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Insertada satisfactoriamente');
            
            return $this->redirect($this->generateUrl('categorynotice'));
        }

        return $this->render('ServiceBundle:CategoryNotice:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a CategoryNotice entity.
     *
     * @param CategoryNotice $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(CategoryNotice $entity)
    {
        $form = $this->createForm(new CategoryNoticeType(), $entity, array(
            'action' => $this->generateUrl('categorynotice_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new CategoryNotice entity.
     *
     */
    public function newAction()
    {
        $entity = new CategoryNotice();
        $form   = $this->createCreateForm($entity);

        return $this->render('ServiceBundle:CategoryNotice:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a CategoryNotice entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:CategoryNotice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoryNotice entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:CategoryNotice:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing CategoryNotice entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:CategoryNotice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoryNotice entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:CategoryNotice:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a CategoryNotice entity.
    *
    * @param CategoryNotice $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(CategoryNotice $entity)
    {
        $form = $this->createForm(new CategoryNoticeType(), $entity, array(
            'action' => $this->generateUrl('categorynotice_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));

        return $form;
    }
    /**
     * Edits an existing CategoryNotice entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:CategoryNotice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find CategoryNotice entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Modificada satisfactoriamente');
            
            return $this->redirect($this->generateUrl('categorynotice'));
        }

        return $this->render('ServiceBundle:CategoryNotice:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a CategoryNotice entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:CategoryNotice')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find CategoryNotice entity.');
            }
            
            $this->get('session')->getFlashBag()->add('notice', 'Eliminada satisfactoriamente');

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('categorynotice'));
    }

    /**
     * Creates a form to delete a CategoryNotice entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('categorynotice_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
