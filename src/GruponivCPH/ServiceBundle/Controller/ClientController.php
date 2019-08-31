<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\Client;
use GruponivCPH\UserBundle\Entity\User;
use GruponivCPH\ServiceBundle\Form\ClientType;

/**
 * Client controller.
 *
 */
class ClientController extends Controller
{
    private function getUploadsDir() {             
        return __DIR__.'/../../../../web/uploads';
    }
    
    public function exportClientsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:Client')->findAll();
        /*        
        $clientsExport = array();
        
        
        foreach($entities as $entity)
        {
            $active = "Activo";
            
            if(!$active)
            {
                $active = "Inactivo";
            }
                
            $gender = $entity->getGender();
            $user = $entity->getUser();
            
            $addressClient = $entity->getAddress();
            
            
            $clientData = array($entity->getName(), $entity->getLastName(),
                $entity->getEmail(), $entity->getAge(), $active, $entity->getStorage(),
                $entity->getCreationDate()->format('d-m-Y'), $gender->getName(), $user->getUserName());
            
            
            foreach($addressClient as $address)
            {
                $strAddress = $address->getAddress() . " "  . $address->getPostalCode() . " " . 
                        $address->getCity() . " " . $address->getCountry();
                
                
                array_push($clientData, $strAddress);
                
                print_r($strAddress);
            }
            
            $clientsExport[] = $clientData;
        }
        
        
        
        $filename = $this->getUploadsDir() .  '/clients.csv';        
        $fp = fopen($filename, 'w');

        foreach ($clientsExport as $fields) {
            fputcsv($fp, $fields);  
        }

        fclose($fp);
        
        $path = $this->getUploadsDir() . "/clients.csv";
        $content = file_get_contents($path);
        
        $response = new Response();

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment;filename="'. "clients.csv");


        $response->setContent($content);
        return $response;
        */
        
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
            
        
        $export = $this->get('export.excel')->setNameOfSheet("Clientes");
        $clientsExport = array();
        foreach($entities as $entity)
        {            
            $active = "Activo";
            
            if(!$active)
            {
                $active = "Inactivo";
            }
                
            $gender = $entity->getGender();
            $user = $entity->getUser();
            
            $dataClient = array($entity->getGender()->getSex(), $entity->getName(), $entity->getLastName(),
                $entity->getEmail(), $entity->getAge(), $active, $entity->getStorage(), $gender->getName());
            
            $addressClient = $entity->getAddress();
            
            foreach($addressClient as $address)
            {
                $strAddress = $address->getAddress() . " "  . $address->getPostalCode() . " " . $address->getLocation() . " " . 
                        $address->getProvince() . " " . $address->getCommunity() . " "  .  $address->getTown() . " " . 
                        $address->getCity() . " " . $address->getCountry() . " " . $address->getEnterprise();
                
                array_push($dataClient, $strAddress);
            }
            
            $clientsExport[] = $dataClient;
        }
        
        $export->writeTable($clientsExport, 20, $estilo, array(15, 30, 20, 35, 15, 15, 10, 10, 60, 80, 80, 80, 80, 80, 80, 80, 80, 80, 50, 50, 50));
        
        $export->writeExport($this->getUploadsDir() . "/clientes");

        $path = $this->getUploadsDir() . "/"  . "clientes.xls";
        $content = file_get_contents($path);

        $response = new Response();

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment;filename="'. "clientes.xls");


        $response->setContent($content);
        return $response;
         
    }
    
    public function deleteAllAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $clientsId = $request->request->get("clients");
        
        foreach($clientsId as $id)
        {
            $client = $em->getRepository("ServiceBundle:Client")->find($id);
            $em->remove($client);
        }
        
        $em->flush();
        
        return $this->redirectToRoute('client');
    }
    
    
    public function importClientsExcelAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $fileName = time() . rand(1, 10000) . "clients.csv";
        $targetPath = $this->getUploadsDir() . "/" . $fileName;
        
        move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetPath);
                
        
        $file = fopen($targetPath, "r");

        
        while(!feof($file))
        {
            $dataClient = fgetcsv($file);
            
            if($dataClient)
            {           
                $client = new Client();
                $client->setName($dataClient[0]);
                $client->setLastName($dataClient[1]);
                $client->setEmail($dataClient[2]);
                $client->setAge($dataClient[3]);

                if($dataClient[4] == "Activo")
                {
                    $client->setActive(true);
                }
                else
                {
                    $client->setActive(false);
                }         

                $client->setStorage(unserialize($dataClient[5]));



                //$client->setCreationDate(unserialize($dataClient[6]));
                $client->setCreationDate(new \DateTime('now'));



                $clientGenderId = $dataClient[7];

                $em = $this->getDoctrine()->getManager();            
                $gender = $em->getRepository("ServiceBundle:Gender")->find((int)$clientGenderId);            
                $client->setGender($gender);
                $client->setEmail($dataClient[2]);

                $gender = $em->getRepository("ServiceBundle:Gender")->find((int)$clientGenderId);


                $user = $em->getRepository("UserBundle:User")->findOneByEmail($dataClient[8]);
                $client->setUser($user);

                $em->persist($client);
                $em->flush();
                
                /*
                $addressData = unserialize($dataClient[9]);


                foreach($addressData as $address)
                {
                    $addressClient = new \GruponivCPH\ServiceBundle\Entity\AddressClient();
                    $addressClient->setAddress($address[0]);
                    $addressClient->setPostalCode($address[1]);
                    $addressClient->setCity($address[2]);

                    $countryId = $address[3];
                    $country = $em->getRepository("ServiceBundle:Country")->find($countryId);
                    $addressClient->setCountry($country);
                    $addressClient->setClient($client);

                    $em->persist($addressClient);
                    $em->flush();
                }  
                 *
                 */ 
            }      
        }
        
        
        fclose($file);
        @unlink($targetPath);
        
        
        return $this->redirectToRoute('client');
    }
    
    
    
    /**
     * Lists all Client entities filtered by creation date
     *
     */
    public function filterClientsByCreationDateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new \GruponivCPH\ServiceBundle\Form\RangeDateType(), null, array(
            'action' => $this->generateUrl('client_filter_date_creation'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Buscar', 'attr' => array('class' => 'btn btn-primary')));
        
        $form->handleRequest($request);
        
        
        if($form->isSubmitted())
        {
            $startDate = $form->get('startDate')->getData();
            $endDate = $form->get('endDate')->getData();
            
            if($startDate && $endDate)      
            {
                $startDate = new \DateTime($startDate->format("Y-m-d") . " 00:00:00");
                $endDate = new \DateTime($endDate->format("Y-m-d") . " 23:59:59");                  
                $entities = $em->getRepository("ServiceBundle:Client")->clientsBetweenDates($startDate, $endDate);
            }
            else
            {
                $entities = $em->getRepository('ServiceBundle:Client')->findAll();
            }
        }
        else
        {
            $entities = $em->getRepository('ServiceBundle:Client')->findAll();
        }
        
        
        $aaData = array();
        foreach ($entities as $ent) {
            $delete_form = $this->createDeleteForm($ent->getId())->createView();
            $action = $this->renderView('ServiceBundle:Client:actions.html.twig', array('delete_form' => $delete_form, 'entity_id' => $ent->getId(), 'entity_name' => $ent->getName()));

            $aaData[] = array(
                'action'  => $action
            );
        }
        

        return $this->render('ServiceBundle:Client:index.html.twig', array(
            'entities' => $entities,
            'aaData' => $aaData,
            'form_range' => $form->createView()
        ));
    }
    
    
    
    /**
     * Lists all Client entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:Client')->findAll();
        
        $aaData = array();
        foreach ($entities as $ent) {
            $delete_form = $this->createDeleteForm($ent->getId())->createView();
            $action = $this->renderView('ServiceBundle:Client:actions.html.twig', array('delete_form' => $delete_form, 'entity_id' => $ent->getId(), 'entity_name' => $ent->getName()));

            $aaData[] = array(
                'action'  => $action
            );
        }
        
         $form = $this->createForm(new \GruponivCPH\ServiceBundle\Form\RangeDateType(), null, array(
            'action' => $this->generateUrl('client_filter_date_creation'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Buscar', 'attr' => array('class' => 'btn btn-primary')));
        

        return $this->render('ServiceBundle:Client:index.html.twig', array(
            'entities' => $entities,
            'aaData' => $aaData,
            'form_range' => $form->createView()
        ));
    }
    
    
    /**
     * Creates a new Client entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Client();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();            
            
            $entity->setStorage("física");            
            $entity->setCreationDate(new \DateTime('now'));
            
            
            
            $user = new User();
            
            $rol = $form->get('role')->getData();            
            $user->setRoles(array($rol));
            
            $user->setUsername($entity->getEmail());
            $user->setEnabled(true);
            $user->setPassword($form->get('password')->getData());
            $user->setEmail($entity->getEmail());
            
            $entity->setUser($user);
            
            
            $em->persist($user);
            $em->flush();
            
            $manipulator = $this->container->get('fos_user.util.user_manipulator');
            $manipulator->changePassword($user->getUsername(), $user->getPassword());
            
                            
            $em->persist($entity);            
            $em->flush();
                    
            
            return $this->redirect($this->generateUrl('client'));
        }

        return $this->render('ServiceBundle:Client:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Client entity.
     *
     * @param Client $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Client $entity)
    {
        $form = $this->createForm(new ClientType(), $entity, array(
            'action' => $this->generateUrl('client_create'),
            'method' => 'POST',
        ));
        
        $form->add('password', 'repeated', array('mapped' => false,
                'type' => 'password',
                'invalid_message' => 'Las dos contraseñas deben coincidir.',
                'options' => array('label' => 'Contraseña')
            ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Client entity.
     *
     */
    public function newAction()
    {
        $entity = new Client();
        $form   = $this->createCreateForm($entity);
        
        
        return $this->render('ServiceBundle:Client:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    
    /**
     * Finds and displays a Client entity.
     *
     */
    public function showOrderAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:OrderClient')->find($id);

        

        return $this->render('ServiceBundle:Client:showOrder.html.twig', array(
            'entity'      => $entity,
        ));
    }
    
    
    /**
     * Finds and displays a Client entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Client')->find($id);

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:Client:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Client entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Client')->find($id);
        
        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Client entity.');
        }

        $editForm = $this->createEditForm($entity);
        
        $usuario = $entity->getUser();
        $editForm->get('role')->setData($usuario->getRoles()[0]);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:Client:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Client entity.
    *
    * @param Client $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Client $entity)
    {
        $form = $this->createForm(new ClientType(), $entity, array(
            'action' => $this->generateUrl('client_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));
        
        $form->add('password', 'repeated', array('mapped' => false,
                'type' => 'password',
                'invalid_message' => 'Las dos contraseñas deben coincidir.',
                'options' => array('label' => 'Contraseña')
            ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));

        return $form;
    }
    /**
     * Edits an existing Client entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Client')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Client entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            $em->flush();

            return $this->redirect($this->generateUrl('client'));
        }

        return $this->render('ServiceBundle:Client:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Client entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:Client')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Client entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('client'));
    }

    /**
     * Creates a form to delete a Client entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('client_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
