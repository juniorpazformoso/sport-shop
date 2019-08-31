<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\AnswerTicket;
use GruponivCPH\ServiceBundle\Form\AnswerTicketType;

/**
 * AnswerTicket controller.
 *
 */
class AnswerTicketController extends Controller
{

    /**
     * Lists all AnswerTicket entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:AnswerTicket')->findAll();

        return $this->render('ServiceBundle:AnswerTicket:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    
    
    
    /**
     * Creates a new AnswerTicket entity.
     *
     */
    public function createAction(Request $request)
    {        
        $entity = new AnswerTicket();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            
            
            $idTicket = (int)$form->get('ticket')->getData();
            
            
            $user = (int)$form->get('user')->getData();
            
            $ticket = $em->getRepository("ServiceBundle:Ticket")->find($idTicket);            
            $client = $ticket->getClient();
            
            
            $questions = $em->getRepository("ServiceBundle:QuestionTicket")->allQuestionOrderByTicketDesc($ticket);          
            $lastQuestion = $questions[0];     
            
            $questionHasAnswer = $em->getRepository("ServiceBundle:AnswerTicket")->findByQuestion($lastQuestion);
            
            if($questionHasAnswer)
            {
                return $this->redirectToRoute('ticket_show', array('id' => $ticket->getId()));
            }
            
            
            $entity->setQuestion($lastQuestion);
            $entity->setUser($em->getRepository("UserBundle:User")->find($user));                                
            $entity->setCreationDate(new \DateTime('now'));
            $ticket->setState("Respondido");
            $ticket->setUpdateDate(new \DateTime('now'));
            
            
            
            $em->persist($entity);
            $em->flush();
            
            

            return $this->redirect($this->generateUrl('ticket_show', array('id' => $ticket->getId())));
        }

        return $this->render('ServiceBundle:AnswerTicket:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a AnswerTicket entity.
     *
     * @param AnswerTicket $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(AnswerTicket $entity)
    {
        $form = $this->createForm(new AnswerTicketType(), $entity, array(
            'action' => $this->generateUrl('answerticket_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new AnswerTicket entity.
     *
     */
    public function newAction()
    {
        $entity = new AnswerTicket();
        $form   = $this->createCreateForm($entity);

        return $this->render('ServiceBundle:AnswerTicket:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a AnswerTicket entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:AnswerTicket')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnswerTicket entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:AnswerTicket:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing AnswerTicket entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:AnswerTicket')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnswerTicket entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:AnswerTicket:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a AnswerTicket entity.
    *
    * @param AnswerTicket $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(AnswerTicket $entity)
    {
        $form = $this->createForm(new AnswerTicketType(), $entity, array(
            'action' => $this->generateUrl('answerticket_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing AnswerTicket entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:AnswerTicket')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find AnswerTicket entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('answerticket_edit', array('id' => $id)));
        }

        return $this->render('ServiceBundle:AnswerTicket:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a AnswerTicket entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:AnswerTicket')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find AnswerTicket entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('answerticket'));
    }

    /**
     * Creates a form to delete a AnswerTicket entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('answerticket_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
