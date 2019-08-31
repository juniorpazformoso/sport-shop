<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\OrderClient;
use GruponivCPH\ServiceBundle\Form\OrderClientType;


/**
 * OrderClient controller.
 *
 */
class OrderClientController extends Controller
{
    
    private function getUploadsDir() {             
        return __DIR__.'/../../../../web/uploads';
    }
    
    public function exportClientsAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $estilo = array(
                    'labels' => array(
                ),
                    'coordinates' => array(
                                'x' => 0,
                                'y' => 1,
                        ),
                    'font' => array(
                        'name'      => 'Arial',


                        'size' =>12,
                        'color'     => array(
                            'rgb' => '255255255'
                        )

                    ),
                    'zebra' => false,
                    'merge' => 2,
                );
            
        
        $export = $this->get('export.excel')->setNameOfSheet("Pedidos");
        $ordersExport = array();
        
        $entities = $em->getRepository('ServiceBundle:OrderClient')->findAll();
        foreach($entities as $entity)
        {            
            $identifier = $entity->getIdentifier();
            $client = $entity->getClient();
            $name = "";
            $lastName = "";
            
            if($client)
            {
                $name = $client->getName();
                $lastName = $client->getLastName();
            }
            
            $date = $entity->getCreationDate()->format("d/m/Y");
            
            $dataOrder = array($identifier, $name, $lastName, $date,
                $entity->getPaymentMethod(), $entity->getStatus(), "€" . $entity->getTotal());
            
            $ordersProduct = $entity->getProducts();
            
            foreach($ordersProduct as $orderProduct)
            {
                $product = $orderProduct->getProduct();
                $str_product = $product->getName() . ": " . $orderProduct->getCount() . " €" . $product->getPrice();
                
                array_push($dataOrder, $str_product);
            }
            
            
            $ordersExport[] = $dataOrder;
        }
        
        $export->writeTable($ordersExport, 20, $estilo, array(15, 30, 20, 25, 15, 15, 15, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50, 50));
        
        $export->writeExport($this->getUploadsDir() . "/pedidos");

        $path = $this->getUploadsDir() . "/"  . "pedidos.xls";
        $content = file_get_contents($path);

        $response = new Response();

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment;filename="'. "pedidos.xls");


        $response->setContent($content);
        return $response;
         
    }
    
    
    /**
     * Lists all OrderClient entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:OrderClient')->orders();
        
        $aaData = array();
        foreach ($entities as $ent) {
            $delete_form = $this->createDeleteForm($ent->getId())->createView();
            $action = $this->renderView('ServiceBundle:OrderClient:actions.html.twig', array('delete_form' => $delete_form, 'entity_id' => $ent->getId(), 'entity_name' => ''));

            $aaData[] = array(
                'action'  => $action
            );
        }

        return $this->render('ServiceBundle:OrderClient:index.html.twig', array(
            'entities' => $entities,
            'aaData' => $aaData,
        ));
    }
    
    
    /**
     * Creates a new OrderClient entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new OrderClient();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('orderclient_show', array('id' => $entity->getId())));
        }

        return $this->render('ServiceBundle:OrderClient:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    
    
    public function deleteAllAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $ordersClient = $request->request->get("orderClients");
        
        foreach($ordersClient as $id)
        {
            $orderClient = $em->getRepository("ServiceBundle:OrderClient")->find($id);
            $em->remove($orderClient);
        }
        
        $em->flush();
        
        return $this->redirectToRoute('orderclient');
    }
    
    

    /**
     * Creates a form to create a OrderClient entity.
     *
     * @param OrderClient $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(OrderClient $entity)
    {
        $form = $this->createForm(new OrderClientType(), $entity, array(
            'action' => $this->generateUrl('orderclient_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new OrderClient entity.
     *
     */
    public function newAction()
    {
        $entity = new OrderClient();
        $form   = $this->createCreateForm($entity);

        return $this->render('ServiceBundle:OrderClient:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a OrderClient entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:OrderClient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OrderClient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:OrderClient:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing OrderClient entity.
     *
     */
    public function editAction(Request $request, $id)
    {
        
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:OrderClient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OrderClient entity.');
        }

        $editForm = $this->createForm(new OrderClientType(), $entity, array(
            'action' => $this->generateUrl('orderclient_edit', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        
        $editForm->add('submit', 'submit', array('label' => 'Modificar'));
        
        $editForm->handleRequest($request);
        
        
        if($editForm->isSubmitted())
        {            
            $em->flush();
            
            $status = $entity->getStatus();
            
            $siteOption = $em->getRepository("ServiceBundle:SiteOption")->findAll()[0];
            $serverEmailIp = $siteOption->getEmailServerIp();
            $serverEmailPort = $siteOption->getEmailServerPort();
            
            $server_user = $siteOption->getEmailServerAddress();
            $server_password = $siteOption->getEmailServerPassword();
                    
            $transport = \Swift_SmtpTransport::newInstance($serverEmailIp, $serverEmailPort, "")
                ->setUsername($server_user)
                ->setPassword($server_password)
            ;

            
            $htmlEmail = "";
            $subject = "";
            
            if($status == "Cancelado")
            {
                $htmlEmail = $this->renderView('ServiceBundle:TemplateEmail/templates:pedido_cancelado.html.twig', array(
                    'orderclient' => $entity
                ));
                
                $subject = "Pedido cancelado";
            }
            elseif($status == "Pendiente")
            {
                $htmlEmail = $this->renderView('ServiceBundle:TemplateEmail/templates:pedido_con_pago_pendiente.html.twig', array(
                    'orderclient' => $entity
                ));
                
                $subject = "Pedido pendiente";
            }
            elseif($status == "Preparación en curso")
            {
                $htmlEmail = $this->renderView('ServiceBundle:TemplateEmail/templates:preparacion_en_curso.html.twig', array(
                    'orderclient' => $entity
                ));
                
                $subject = "Preparación en curso";
            }
            elseif($status == "Enviado")
            {
                $htmlEmail = $this->renderView('ServiceBundle:TemplateEmail/templates:pedido_enviado.html.twig', array(
                    'orderclient' => $entity
                ));
                
                $subject = "Pedido en envío";
            }
            elseif($status == "Entregado")
            {
                $htmlEmail = $this->renderView('ServiceBundle:TemplateEmail/templates:pedido_entregado.html.twig', array(
                    'orderclient' => $entity
                ));
                
                $subject = "Pedido entregado";
            }
            
            
            
            
            $mailer = \Swift_Mailer::newInstance($transport);
            $message = \Swift_Message::newInstance($subject)

                ->setFrom(array($server_user))

                ->setTo(array($entity->getClient()->getEmail()))

                ->setBody($htmlEmail, 'text/html');
            
            
            try{
                
                $mailer->send($message);
            }
            catch (\Exception $exc)
            {
                $headers = 'From: ' . $server_user . PHP_EOL ;           
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                
                mail($entity->getClient()->getEmail(), $subject, $htmlEmail, $headers);
            }
            
            return $this->redirect($this->generateUrl('orderclient'));
        }
        
        

        return $this->render('ServiceBundle:OrderClient:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a OrderClient entity.
    *
    * @param OrderClient $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(OrderClient $entity)
    {
        $form = $this->createForm(new OrderClientType(), $entity, array(
            'action' => $this->generateUrl('orderclient_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));

        return $form;
    }
    
    
    /**
     * Edits an existing OrderClient entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:OrderClient')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OrderClient entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->add('status', 'choice', array('choices' => array("Pendiente" => "Pendiente", 
                                                "Cancelado" => "Cancelado",
                                                "Finalizado" => "Finalizado")));
        $editForm->handleRequest($request);
        

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('orderclient'));
        }

        return $this->render('ServiceBundle:OrderClient:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    
    /**
     * Deletes a OrderClient entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:OrderClient')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find OrderClient entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('orderclient'));
    }

    /**
     * Creates a form to delete a OrderClient entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('orderclient_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
