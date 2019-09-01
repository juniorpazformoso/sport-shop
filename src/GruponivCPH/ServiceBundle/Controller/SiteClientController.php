<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GruponivCPH\ServiceBundle\Entity\Category;
use GruponivCPH\ServiceBundle\Util\Util;
use GruponivCPH\ServiceBundle\Entity\Client;
use GruponivCPH\ServiceBundle\Form\ClientAccountType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use GruponivCPH\UserBundle\Entity\User;
use GruponivCPH\ServiceBundle\Entity\AddressClient;
use GruponivCPH\ServiceBundle\Form\AddressAccountClientType;
use GruponivCPH\ServiceBundle\Form\ClientEditAccountType;

class SiteClientController extends Controller
{
    public function showTicketAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Ticket')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Ticket entity.');
        }        
        
        //Preparando formularios para preguntas y respuestas
        
        /***   Formulario para preguntas         ****/
        $questionTicket = new \GruponivCPH\ServiceBundle\Entity\QuestionTicket();
        
        $formQuestionTicket = $this->createForm(new \GruponivCPH\ServiceBundle\Form\QuestionTicketType(), $questionTicket,
                array('action' => $this->generateUrl('questionticket_create')));                
				
        $formQuestionTicket->get('ticket')->setData($entity->getId());        
        
        
        /***   Formulario para respuestas ****/
        $answerTicket = new \GruponivCPH\ServiceBundle\Entity\AnswerTicket();
		
        $formAnswerTicket = $this->createForm(new \GruponivCPH\ServiceBundle\Form\AnswerTicketType(), $answerTicket,
                array('action' => $this->generateUrl('answerticket_create')));
				
        $formAnswerTicket->get('ticket')->setData($entity->getId()); 
        
        
        $formAnswerTicket->get('user')->setData($this->getUser()->getId()); 
        
        
        
        
        $questions = $em->getRepository("ServiceBundle:QuestionTicket")->allQuestionOrderByTicket($entity);
        
        
        return $this->render('ServiceBundle:Site/client:show_ticket.html.twig', array(
            'ticket'      => $entity,
            'formQuestionTicket' => $formQuestionTicket->createView(),
            'formAnswerTicket' => $formAnswerTicket->createView(),
            'questions' => $questions,
        ));
    }
    
    
    /**
     * Displays a form to create a new Ticket entity.
     *
     */
    public function newTicketAction(Request $request)
    {
        $entity = new \GruponivCPH\ServiceBundle\Entity\Ticket();
        
        $form = $this->createFormBuilder($entity, array(
            'action' => $this->generateUrl('site_ticket_new'),
            'method' => 'POST',
        ));
        
        $form->add('subjet');
        $form->add('question', 'textarea', array('label' => 'Mensaje', 'mapped' => false));

        $form->add('submit', 'submit', array('label' => 'Crear ticket'));
        
        $form = $form->getForm();
        
        $form->handleRequest($request);
            
        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            
            $currentDate = new \DateTime('now');
            $entity->setCreationDate($currentDate);
            $entity->setUser($this->getUser());
            $entity->setUpdateDate($currentDate);
            $entity->setState("En espera de respuesta");
            $user = $this->getUser();
            $entity->setClient($em->getRepository("ServiceBundle:Client")->findOneByUser($user));
            
            $em->persist($entity);
            $em->flush();
            
            
            $questionTicket = new \GruponivCPH\ServiceBundle\Entity\QuestionTicket();
            $questionTicket->setTicket($entity);
            $questionTicket->setCreationDate(new \DateTime('now'));
            $questionTicket->setQuestion($form->get('question')->getData());
            
            $em->persist($questionTicket);
            $em->flush();
            
            return $this->redirectToRoute('tickets_client');   
        }

        return $this->render('ServiceBundle:Site/client:new_ticket.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }
    
    /**
     *
     */
    public function ticketsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();
        
        
        $client = $em->getRepository("ServiceBundle:Client")->findOneByUser($user);
        
        
        return $this->render('ServiceBundle:Site/client:ticket.html.twig', array(
            'client' => $client,
        ));
    }
    
    
    public function reviewOrderAction(\GruponivCPH\ServiceBundle\Entity\OrderClient $orderClient)
    {
        return $this->render('ServiceBundle:Site/client:reviewOrder.html.twig',
                array('orderClient' => $orderClient));
    }
    
    
    public function clientOrderHistoryAction(Request $request)
    {
        $user = $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository("ServiceBundle:Client")->findOneByUser($user);
        
        
        $historyOrders = $em->getRepository("ServiceBundle:OrderClient")->orderClient($client);
        
        return $this->render('ServiceBundle:Site/client:historyOrders.html.twig',
                array('historyOrders' => $historyOrders));
        
    }
    
    
    public function checkClientUniqueEmailAction(Request $request)
    {        
        $em = $this->getDoctrine()->getManager();
        
        $email = $request->request->get('email');
        $client = $em->getRepository("ServiceBundle:Client")->findByEmail($email);
        
        $item = array('validMail' => count($client) == 0);
        $item = json_encode($item);
        
        return new Response($item, 200);
    }
    
    
    
    
    public function myAccountAction()
    {        
        return $this->render('ServiceBundle:Site/client:account.html.twig');
    }
    
    
    public function personalDataAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
            
        $user = $this->getUser();
        $client = $em->getRepository("ServiceBundle:Client")->findOneByUser($user);
            
        $form   = $this->createUpdateForm();
        $form->get('age')->setData($client->getAge());
        $form->get('name')->setData($client->getName());
        $form->get('lastName')->setData($client->getLastName());        
        $form->get('dni_nif')->setData($client->getDniNif());
        
        
        $form->handleRequest($request);
        
        if($form->isValid())
        {
            
            
            $client->setGender($form->get('gender')->getData());
            $client->setName($form->get('name')->getData());
            $client->setLastName($form->get('lastName')->getData());
            //$client->setEmail($user->getEmail());
            $client->setAge($form->get('age')->getData());
            $client->setDniNif($form->get('dni_nif')->getData());            
            $client->setGender($form->get('gender')->getData());
            $em->flush();
        }

        return $this->render('ServiceBundle:Site/client:personal_data.html.twig', array(
            'client' => $client,
            'form'   => $form->createView(),
        ));
        
        return $this->render('ServiceBundle:Site/client:personal_data.html.twig');
    }
    
    
    public function addressClientAction()
    {        
        $user = $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $client = $em->getRepository("ServiceBundle:Client")->findOneByUser($user);
        $address = $client->getAddress();
        
        return $this->render('ServiceBundle:Site/client:address.html.twig', array('entities' => $address));
    }
    
    
    
    public function initAccountAction(Request $request)
    {            
        /** @var $session \Symfony\Component\HttpFoundation\Session\Session */
        $session = $request->getSession();

        if (class_exists('\Symfony\Component\Security\Core\Security')) {
            $authErrorKey = Security::AUTHENTICATION_ERROR;
            $lastUsernameKey = Security::LAST_USERNAME;
        } else {
            // BC for SF < 2.6
            $authErrorKey = SecurityContextInterface::AUTHENTICATION_ERROR;
            $lastUsernameKey = SecurityContextInterface::LAST_USERNAME;
        }

        // get the error if any (works with forward and redirect -- see below)
        if ($request->attributes->has($authErrorKey)) {
            $error = $request->attributes->get($authErrorKey);
        } elseif (null !== $session && $session->has($authErrorKey)) {
            $error = $session->get($authErrorKey);
            $session->remove($authErrorKey);
        } else {
            $error = null;
        }

        if (!$error instanceof AuthenticationException) {
            $error = null; // The value does not come from the security component.
        }

        // last username entered by the user
        $lastUsername = (null === $session) ? '' : $session->get($lastUsernameKey);

        if ($this->has('security.csrf.token_manager')) {
            $csrfToken = $this->get('security.csrf.token_manager')->getToken('authenticate')->getValue();
        } else {
            // BC for SF < 2.4
            $csrfToken = $this->has('form.csrf_provider')
                ? $this->get('form.csrf_provider')->generateCsrfToken('authenticate')
                : null;
        }

        return $this->renderLogin(array(
            'last_username' => $lastUsername,
            'error' => $error,
            'csrf_token' => $csrfToken,
        ));
    }
    
        //return $this->render('ServiceBundle:Site/client:init_account.html.twig');
    
    
    protected function renderLogin(array $data)
    {
        //return $this->render('FOSUserBundle:Security:login.html.twig', $data);
        return $this->render('ServiceBundle:Site/client:init_account.html.twig', $data);
    }
    
    /**
     * Displays a form to create a new Client entity.
     *
     */
    public function newAction($email)
    {        
        $entity = new User();
        
        $entity->setEmail($email);
        $form   = $this->createCreateForm($entity);

        return $this->render('ServiceBundle:Site/client:create_client.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    
    
    
    public function requestActivationAccountAction(Request $request, $email)
    {        
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserByEmail($email);
        
        
        if($user)
        {
            $em = $this->getDoctrine()->getManager();
            $tokenGenerator = $this->get('fos_user.util.token_generator');        
            $token = $tokenGenerator->generateToken();
            $user->setConfirmationToken($token);
            $this->get('fos_user.user_manager')->updateUser($user);
            
            $em->flush();
            
            
            
            $siteOption = $em->getRepository("ServiceBundle:SiteOption")->findAll()[0];
            $serverEmailIp = $siteOption->getEmailServerIp();
            $serverEmailPort = $siteOption->getEmailServerPort();
            
            $server_user = $siteOption->getEmailServerAddress();
            $server_password = $siteOption->getEmailServerPassword();
                    
            $transport = \Swift_SmtpTransport::newInstance($serverEmailIp, $serverEmailPort, "")
                ->setUsername($server_user)
                ->setPassword($server_password)
            ;

            
            $client = $em->getRepository("ServiceBundle:Client")->findOneByUser($user);
            
            $htmlEmail = $this->renderView('ServiceBundle:TemplateEmail/templates:create_account.html.twig', array(
                'client' => $client,
                'token' => $token
            ));
            
            
            $mailer = \Swift_Mailer::newInstance($transport);
            $message = \Swift_Message::newInstance('Creación de cuenta en Dabberspain')

                ->setFrom(array($server_user))

                ->setTo(array($email))

                ->setBody($htmlEmail, 'text/html');
            
            
            try{
                $mailer->send($message);
                //return new Response("EMAIL SEND SUCCESS", 400);
            }
            catch (\Exception $exc)
            {
                $headers = 'From: ' . $server_user . PHP_EOL ;           
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                mail($email, "Creación de cuenta en Dabberspain", $htmlEmail, $headers);
            }
            
            $this->get('session')->getFlashBag()->add('notice', 'Se han enviado instrucciones a su correo electrónico para activar su cuenta.');
        }
        else
        {
            $this->get('session')->getFlashBag()->add('notice', 'No existe ninguna cuenta con esta dirección de correo electrónico.');
        }
        
        
        return $this->redirect($this->generateUrl('service_init_account'));
    }
    
    
    public function requestPasswordAccountAction(Request $request, $email)
    {        
        $userManager = $this->container->get('fos_user.user_manager');
        $user = $userManager->findUserByEmail($email);
        
        
        if($user)
        {
            $em = $this->getDoctrine()->getManager();
            $tokenGenerator = $this->get('fos_user.util.token_generator');        
            $token = $tokenGenerator->generateToken();
            $user->setConfirmationToken($token);
            $this->get('fos_user.user_manager')->updateUser($user);
            
            $em->flush();
            
            
            
            $siteOption = $em->getRepository("ServiceBundle:SiteOption")->findAll()[0];
            $serverEmailIp = $siteOption->getEmailServerIp();
            $serverEmailPort = $siteOption->getEmailServerPort();
            
            $server_user = $siteOption->getEmailServerAddress();
            $server_password = $siteOption->getEmailServerPassword();
                    
            $transport = \Swift_SmtpTransport::newInstance($serverEmailIp, $serverEmailPort, "")
                ->setUsername($server_user)
                ->setPassword($server_password)
            ;

            
            $client = $em->getRepository("ServiceBundle:Client")->findOneByUser($user);
            
            $htmlEmail = $this->renderView('ServiceBundle:TemplateEmail/templates:reestablecer_password.html.twig', array(
                'client' => $client,
                'token' => $token
            ));
            
            
            $mailer = \Swift_Mailer::newInstance($transport);
            $message = \Swift_Message::newInstance("Recuperar contraseña")

                ->setFrom(array($server_user))

                ->setTo(array($email))

                ->setBody($htmlEmail, 'text/html');
            
            
            try{
                $mailer->send($message);
            }
            catch (\Exception $exc)
            {
                $headers = 'From: ' . $server_user . PHP_EOL ;           
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                mail($email, "Recuperar contraseña", $htmlEmail, $headers);
            }
            
            $this->get('session')->getFlashBag()->add('notice', 'Se han enviado instrucciones a su correo electrónico para recuperar su contraseña.');
        }
        else
        {
            $this->get('session')->getFlashBag()->add('notice', 'No existe ninguna cuenta con esta dirección de correo electrónico.');
        }
        
        
        return $this->redirect($this->generateUrl('service_init_account'));
    }
    
    
    
    public function confirmRequestPasswordAction(Request $request, $token)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        
        $user = $userManager->findUserByConfirmationToken($token);
        
        if($request->getMethod() == "POST")
        {
            $contrasena = $request->request->get('password');
            if($user)
            {
                $manipulator = $this->container->get('fos_user.user_manager');
                $user->setPlainPassword($contrasena);
                $manipulator->updatePassword($user);
                
                $em = $this->getDoctrine()->getManager(); 
                $em->flush();
                
                $this->get('session')->getFlashBag()->add('notice', 'Su contraseña se reestablecio de manera exitosa.' );
            }
        }
        else
        {
            if($user)
            {   
                $em = $this->getDoctrine()->getManager();
                $client = $em->getRepository("ServiceBundle:Client")->findOneByUser($user);      
                return $this->render('ServiceBundle:Site/client:new_password.html.twig');
            }
            else
            {
                $this->get('session')->getFlashBag()->add('notice', 'Debido a problemas de seguridad el enlace de recuperación se bloqueo. Intente solicitar su contraseña de nuevo por favor.' );
            }
        }
        
        return $this->redirect($this->generateUrl('service_init_account'));
    }
    
    
    /**
     * Creates a new Client entity.
     *
     */
    public function confirmAccountAction(Request $request, $token)
    {
        $userManager = $this->container->get('fos_user.user_manager');
        
        $user = $userManager->findUserByConfirmationToken($token);
        
        if($user)
        {   
            $em = $this->getDoctrine()->getManager();
            $client = $em->getRepository("ServiceBundle:Client")->findOneByUser($user);
            $client->setActive(true);            
            $user->setEnabled(true);
            
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('notice', 'Su cuenta fue activada exitosamente.');
        }
        else
        {
            $this->get('session')->getFlashBag()->add('notice', 'Su cuenta no pudo ser activada correctamente.');
        }
        
        return $this->redirect($this->generateUrl('service_init_account'));
    }
    
    
    /**
     * Creates a new Client entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            
            
            $em = $this->getDoctrine()->getManager();
            $entity->setRoles(array("ROLE_CLIENTE"));
            $entity->setUsername($entity->getEmail());
            $entity->setEnabled(false);
            $em->persist($entity);
            
            $tokenGenerator = $this->get('fos_user.util.token_generator');        
            $token = $tokenGenerator->generateToken();
            $entity->setConfirmationToken($token);
            $this->get('fos_user.user_manager')->updateUser($entity);
            
            $em->flush();
            
            $client = new Client();
            
            $client->setGender($form->get('gender')->getData());
            $client->setName($form->get('name')->getData());
            $client->setLastName($form->get('lastName')->getData());
            $client->setEmail($entity->getEmail());
            $client->setAge($form->get('age')->getData());
            $client->setDniNif($form->get('dni_nif')->getData());
                    
            
            $client->setCreationDate(new \DateTime('now'));
            $client->setActive(true);
            $client->setStorage("online");
            $client->setUser($entity);
            $em->persist($client);
            $em->flush();
            
            
            $manipulator = $this->container->get('fos_user.util.user_manipulator');
            $manipulator->changePassword($entity->getUsername(), $entity->getPassword());
            
            $this->get('session')->getFlashBag()->add('notice', 'Se han enviado instrucciones a su correo electrónico para activar su cuenta.');
            
            
            $siteOption = $em->getRepository("ServiceBundle:SiteOption")->findAll()[0];
            $serverEmailIp = $siteOption->getEmailServerIp();
            $serverEmailPort = $siteOption->getEmailServerPort();
            
            $server_user = $siteOption->getEmailServerAddress();
            $server_password = $siteOption->getEmailServerPassword();
                    
            $transport = \Swift_SmtpTransport::newInstance($serverEmailIp, $serverEmailPort, "")
                ->setUsername($server_user)
                ->setPassword($server_password)
            ;

            

            
            $htmlEmail = $this->renderView('ServiceBundle:TemplateEmail/templates:create_account.html.twig', array(
                'client' => $client,
                'token' => $token
            ));
            
            
            $mailer = \Swift_Mailer::newInstance($transport);
            $message = \Swift_Message::newInstance('Creación de cuenta en Dabberspain')

                ->setFrom(array($entity->getEmail()))

                ->setTo(array($server_user))

                ->setBody($htmlEmail, 'text/html');
            
            
            try{
                $mailer->send($message);
                //return new Response("EMAIL SEND SUCCESS", 400);
            }
            catch (\Exception $exc)
            {
                $headers = 'From: ' . $server_user . PHP_EOL ;           
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                mail($entity->getEmail(), "Creación de cuenta en Dabberspain", $htmlEmail, $headers);
            }
            
            
            return $this->redirect($this->generateUrl('service_init_account'));
        }

        return $this->render('ServiceBundle:Site/client:create_client.html.twig', array(
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
    private function createUpdateForm()
    {
        $form = $this->createForm(new ClientEditAccountType(), array(
            'action' => $this->generateUrl('account_personal_data'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));

        return $form;
    }
    
    /**
     * Creates a form to create a Client entity.
     *
     * @param Client $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new ClientAccountType(), $entity, array(
            'action' => $this->generateUrl('service_create_account', array('email' => $entity->getEmail())),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Registrarse'));

        return $form;
    }
    
    
    
    private function createFormAddress(AddressClient $entity)
    {
        $form = $this->createForm(new AddressAccountClientType(), $entity, array(
            'action' => $this->generateUrl('service_create_client_address'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }
    
    
    public function newAddressClientAction()
    {
        $entity = new AddressClient();
        $form   = $this->createFormAddress($entity);

        return $this->render('ServiceBundle:Site/client:create_client_address.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
    
    
    public function createAddressClientAction(Request $request)
    {
        $entity = new AddressClient();
        $form = $this->createFormAddress($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $user = $this->getUser();
            $client = $em->getRepository("ServiceBundle:Client")->findOneByUser($user);            
            $entity->setClient($client);
            $em->persist($entity);
            $em->flush();

            
            return $this->redirect($this->generateUrl('service_address_client'));
        }

        return $this->render('ServiceBundle:AddressClient:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
}
