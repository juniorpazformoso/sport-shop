<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\Snippet;
use GruponivCPH\ServiceBundle\Form\SnippetType;

/**
 * Snippet controller.
 *
 */
class SnippetController extends Controller
{

    /**
     * Lists all Snippet entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:Snippet')->findAll();
        
        $aaData = array();
        foreach ($entities as $ent) {
            $delete_form = $this->createDeleteForm($ent->getId())->createView();
            $action = $this->renderView('ServiceBundle:Snippet:actions.html.twig', array('delete_form' => $delete_form, 'entity_id' => $ent->getId(), 'entity_name' => $ent->getTitle()));

            $aaData[] = array(
                'action'  => $action
            );
        }

        return $this->render('ServiceBundle:Snippet:index.html.twig', array(
            'entities' => $entities,
            'aaData' => $aaData,
        ));
    }
    /**
     * Creates a new Snippet entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Snippet();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('snippet_show', array('id' => $entity->getId())));
        }

        return $this->render('ServiceBundle:Snippet:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Snippet entity.
     *
     * @param Snippet $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Snippet $entity)
    {
        $form = $this->createForm(new SnippetType(), $entity, array(
            'action' => $this->generateUrl('snippet_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Snippet entity.
     *
     */
    public function newAction()
    {
        $entity = new Snippet();
        $form   = $this->createCreateForm($entity);

        return $this->render('ServiceBundle:Snippet:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Snippet entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Snippet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Snippet entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:Snippet:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Snippet entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Snippet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Snippet entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:Snippet:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Snippet entity.
    *
    * @param Snippet $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Snippet $entity)
    {
        $form = $this->createForm(new SnippetType(), $entity, array(
            'action' => $this->generateUrl('snippet_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));

        return $form;
    }
    /**
     * Edits an existing Snippet entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Snippet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Snippet entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Modificado satisfactoriamente');
            
            return $this->redirect($this->generateUrl('snippet'));
        }

        return $this->render('ServiceBundle:Snippet:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Snippet entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:Snippet')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Snippet entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('snippet'));
    }

    /**
     * Creates a form to delete a Snippet entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('snippet_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
