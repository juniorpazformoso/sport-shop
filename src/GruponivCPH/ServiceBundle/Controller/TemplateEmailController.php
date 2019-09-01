<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\TemplateEmail;
use GruponivCPH\ServiceBundle\Form\TemplateEmailType;
use GruponivCPH\ServiceBundle\Entity\EmailSender;


/**
 * TemplateEmail controller.
 *
 */
class TemplateEmailController extends Controller
{

    /**
     * Lists all TemplateEmail entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:TemplateEmail')->findAll();
        
        $aaData = array();
        foreach ($entities as $ent) {
            $delete_form = $this->createDeleteForm($ent->getId())->createView();
            $action = $this->renderView('ServiceBundle:TemplateEmail:actions.html.twig', array('delete_form' => $delete_form, 'entity_id' => $ent->getId(), 'entity_name' => $ent->getTypeEmail()));

            $aaData[] = array(
                'action'  => $action
            );
        }
        
        $emailSender = $em->getRepository("ServiceBundle:EmailSender")->findAll()[0];
        $form   = $this->createEmailSenderForm($emailSender);
        
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($emailSender);
            $em->flush();
        }
                
        

        return $this->render('ServiceBundle:TemplateEmail:index.html.twig', array(
            'entities' => $entities,
            'aaData' => $aaData,
            'form' => $form->createView()
        ));
    }
    
    private function createEmailSenderForm(EmailSender $entity)
    {
        $form = $this->createForm(new \GruponivCPH\ServiceBundle\Form\EmailSenderType(), $entity, array(
            'action' => $this->generateUrl('templateemail'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Guardar'));

        return $form;
    }
    
    /**
     * Creates a new TemplateEmail entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new TemplateEmail();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('templateemail_show', array('id' => $entity->getId())));
        }

        return $this->render('ServiceBundle:TemplateEmail:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TemplateEmail entity.
     *
     * @param TemplateEmail $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TemplateEmail $entity)
    {
        $form = $this->createForm(new TemplateEmailType(), $entity, array(
            'action' => $this->generateUrl('templateemail_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new TemplateEmail entity.
     *
     */
    public function newAction()
    {
        $entity = new TemplateEmail();
        $form   = $this->createCreateForm($entity);

        return $this->render('ServiceBundle:TemplateEmail:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TemplateEmail entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:TemplateEmail')->find($id);
        
        $typeEmail = $entity->getTypeemail();
        
        if($typeEmail == "Creación de cuenta")
        {
            return $this->render('ServiceBundle:TemplateEmail/templates:create_account.html.twig', array(
                'demo' => True,
            ));
        }
           if($typeEmail == "Pedido con pago aceptado")
        {
            return $this->render('ServiceBundle:TemplateEmail/templates:pedido_con_pago_aceptado.html.twig', array(
                'demo' => True,
            ));
        }
           if($typeEmail == "Pedido con pago pendiente")
        {
            return $this->render('ServiceBundle:TemplateEmail/templates:pedido_con_pago_pendiente.html.twig', array(
                'demo' => True,
            ));
        }
             if($typeEmail == "Error de pago")
        {
            return $this->render('ServiceBundle:TemplateEmail/templates:error_de_pago.html.twig', array(
                'demo' => True,
            ));
        }
             if($typeEmail == "Pago aceptado")
        {
            return $this->render('ServiceBundle:TemplateEmail/templates:pago_aceptado.html.twig', array(
                'demo' => True,
            ));
        }
             if($typeEmail == "Preparacion en curso")
        {
            return $this->render('ServiceBundle:TemplateEmail/templates:preparacion_en_curso.html.twig', array(
                'demo' => True,
            ));
        }
            if($typeEmail == "Pedido enviado")
        {
            return $this->render('ServiceBundle:TemplateEmail/templates:pedido_enviado.html.twig', array(
                'demo' => True,
            ));
        }
           if($typeEmail == "Reestablecer contrasenna")
        {
            return $this->render('ServiceBundle:TemplateEmail/templates:reestablecer_password.html.twig', array(
                'demo' => True,
            ));
        }
           if($typeEmail == "Envio de factura")
        {
            return $this->render('ServiceBundle:TemplateEmail/templates:envio_factura.html.twig', array(
                'demo' => True,
            ));
        }
            if($typeEmail == "Nuevo pedido")
        {
            return $this->render('ServiceBundle:TemplateEmail/templates:nuevo_pedido.html.twig', array(
                'demo' => True,
            ));
        }
            if($typeEmail == "Pago fallido")
        {
            return $this->render('ServiceBundle:TemplateEmail/templates:pago_fallido.html.twig', array(
                'demo' => True,
            ));
        }
               if($typeEmail == "Pedido cancelado")
        {
            return $this->render('ServiceBundle:TemplateEmail/templates:pedido_cancelado.html.twig', array(
                'demo' => True,
            ));
        }
                  if($typeEmail == "Solicitud de factura")
        {
            return $this->render('ServiceBundle:TemplateEmail/templates:solicitud_factura.html.twig', array(
                'demo' => True,
            ));
        }
                  if($typeEmail == "Aviso stock")
        {
            return $this->render('ServiceBundle:TemplateEmail/templates:aviso_stock.html.twig', array(
                'demo' => True,
            ));
        }

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TemplateEmail entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        
    }

    /**
     * Displays a form to edit an existing TemplateEmail entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:TemplateEmail')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TemplateEmail entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:TemplateEmail:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TemplateEmail entity.
    *
    * @param TemplateEmail $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TemplateEmail $entity)
    {
        $form = $this->createForm(new TemplateEmailType(), $entity, array(
            'action' => $this->generateUrl('templateemail_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));

        return $form;
    }
    /**
     * Edits an existing TemplateEmail entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:TemplateEmail')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TemplateEmail entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('templateemail'));
        }

        return $this->render('ServiceBundle:TemplateEmail:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TemplateEmail entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:TemplateEmail')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TemplateEmail entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('templateemail'));
    }

    /**
     * Creates a form to delete a TemplateEmail entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('templateemail_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
