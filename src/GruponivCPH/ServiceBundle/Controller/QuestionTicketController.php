<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\QuestionTicket;
use GruponivCPH\ServiceBundle\Form\QuestionTicketType;

/**
 * QuestionTicket controller.
 *
 */
class QuestionTicketController extends Controller
{

    /**
     * Lists all QuestionTicket entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:QuestionTicket')->findAll();

        return $this->render('ServiceBundle:QuestionTicket:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new QuestionTicket entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new QuestionTicket();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $idTicket = (int)$form->get('ticket')->getData();
            $ticket = $em->getRepository("ServiceBundle:Ticket")->find($idTicket);
            $entity->setTicket($ticket);
            $entity->setCreationDate(new \DateTime('now'));
            $ticket->setUpdateDate(new \DateTime('now'));
            
            
            $ticket->setState("En espera de respuesta");
            
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('showTicket', array('id' => $ticket->getId())));
        }

        return $this->render('ServiceBundle:QuestionTicket:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a QuestionTicket entity.
     *
     * @param QuestionTicket $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(QuestionTicket $entity)
    {
        $form = $this->createForm(new QuestionTicketType(), $entity, array(
            'action' => $this->generateUrl('questionticket_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new QuestionTicket entity.
     *
     */
    public function newAction()
    {
        $entity = new QuestionTicket();
        $form   = $this->createCreateForm($entity);

        return $this->render('ServiceBundle:QuestionTicket:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a QuestionTicket entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:QuestionTicket')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find QuestionTicket entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:QuestionTicket:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing QuestionTicket entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:QuestionTicket')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find QuestionTicket entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:QuestionTicket:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a QuestionTicket entity.
    *
    * @param QuestionTicket $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(QuestionTicket $entity)
    {
        $form = $this->createForm(new QuestionTicketType(), $entity, array(
            'action' => $this->generateUrl('questionticket_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing QuestionTicket entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:QuestionTicket')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find QuestionTicket entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('questionticket_edit', array('id' => $id)));
        }

        return $this->render('ServiceBundle:QuestionTicket:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a QuestionTicket entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:QuestionTicket')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find QuestionTicket entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('questionticket'));
    }

    /**
     * Creates a form to delete a QuestionTicket entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('questionticket_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
