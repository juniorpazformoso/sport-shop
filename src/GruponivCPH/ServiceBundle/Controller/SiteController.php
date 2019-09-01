<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GruponivCPH\ServiceBundle\Entity\Category;
use GruponivCPH\ServiceBundle\Util\Util;
use GruponivCPH\ServiceBundle\Form\OrderClientType;
use GruponivCPH\ServiceBundle\tpvRedsys\RedsysAPI;

class SiteController extends Controller
{
    
    public function searchAction(Request $request)
    {
        $query_term = $request->request->get('q');
        
        
        
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository("ServiceBundle:Product")->productsSearch($query_term);
        
        return $this->render('ServiceBundle:Site/Product:searchProduct.html.twig', array('products' => $products));
    }
    
    public function menuPalasAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $categories = $em->getRepository("ServiceBundle:Category")->findAll();
        
        return $this->render('ServiceBundle:Site:menu-palas.html.twig', array('categories' => $categories));
    }
    
    public function finalEffectiveInfoAction(Request $request, \GruponivCPH\ServiceBundle\Entity\OrderClient $orderClient)
    {
        $em = $this->getDoctrine()->getManager();
        
        
        return $this->render('ServiceBundle:Site/methodPayment:effective.html.twig', array(
            'orderClient' => $orderClient,   
            'effectiveStep' => $em->getRepository("ServiceBundle:Snippet")->findOneByKey("method-effective")->getContent()
        ));
    }
    
    
    public function finalRepaymentInfoAction(Request $request, \GruponivCPH\ServiceBundle\Entity\OrderClient $orderClient)
    {
        $em = $this->getDoctrine()->getManager();
        
        
        return $this->render('ServiceBundle:Site/methodPayment:repayment.html.twig', array(
            'orderClient' => $orderClient,   
            'repaymentMethod' => $em->getRepository("ServiceBundle:Snippet")->findOneByKey("method-repayment")->getContent()
        ));
    }
    
    public function tpvPaymentSuccessAction(Request $request)
    {
        mail("junior.paz.formoso@gmail.com", "ENVIO EXITOSO DESDE TPV", "ENVIO EXITOSO DESDE TPV" , $headers);
        
        exit();
    }
    
    
    
    public function notificationTPVAction(Request $request)
    {        
        $miObj = new RedsysAPI();
        $version =  $request->request->get("Ds_SignatureVersion");
        $datos = $request->request->get("Ds_MerchantParameters");
        $signatureRecibida = $request->request->get("Ds_Signature");

        $decodec = $miObj->decodeMerchantParameters($datos);	
        $codigoRespuesta = $miObj->getParameter("Ds_Response");
        
        mail("junior.paz.formoso@gmail.com", "Pago de TPV notificaci", "Envio de mail cuando se compra en Paypal Notificacion" , $headers);
        
        exit();
    }
    
    public function tpvPaymentUnsuccessAction(Request $request)
    {        
        mail("junior.paz.formoso@gmail.com", "ENVIO CANCELADO DESDE TPV", "ENVIO CANCELADO DESDE TPV" , $headers);
        
        exit();
    }
    
    
    public function compraExitosaAction(Request $request)
    {        
        $em = $this->getDoctrine()->getManager();
        $thankPaypalMessage = $em->getRepository("ServiceBundle:Snippet")
                ->findOneByKey("paypal-complete-order")->getContent();
        
        return $this->render('ServiceBundle:Site:paymentSuccess.html.twig', 
            array('thankPaypalMessage' => $thankPaypalMessage));
    }
    
    public function ipnNotificationPaypalAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        $products = $em->getRepository("ServiceBundle:Product")->findAll();        
        
        /* CHECK THESE 4 THINGS BEFORE PROCESSING THE TRANSACTION, HANDLE THEM AS YOU WISH
        1. Make sure that business email returned is your business email
        2. Make sure that the transaction’s payment status is “completed”
        3. Make sure there are no duplicate txn_id
        4. Make sure the payment amount matches what you charge for items. (Defeat Price-Jacking) */
        
        //Falta verificar los pasos anteriores
        
        $txn_id = $_POST['txn_id'];     
        
        
        $orderclient_id = $_POST['custom'];
        
        $orderClient = $em->getRepository("ServiceBundle:OrderClient")->find($orderclient_id);
        $orderClient->setStatus("Preparación en curso");
        $orderClient->setTxnId($txn_id);
        $em->flush();
        
        
        mail("junior.paz.formoso@gmail.com", "Pago de TPV notificación llego", "Envio notificacion Paypal" , $headers);
        
        exit();
    }
    
    
    
    public function areaTestEmailAction(Request $request)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        
        if($request->getMethod() == "POST")
        {
            $serverEmailIp = $_POST['serverip'];
            $serverEmailPort = $_POST['serverport'];
            $secureMethod = $_POST['secure'];

            $server_user = $_POST['serveruser'];
            $server_password = $_POST['serverpass'];
            

            $email_from = $_POST['emailfrom'];
            $email_to = $_POST['emailto'];
            
            
            
            
            $transport = \Swift_SmtpTransport::newInstance($serverEmailIp, $serverEmailPort, $secureMethod)
                ->setUsername($server_user)
                ->setPassword($server_password)
            ;

            $mailer = \Swift_Mailer::newInstance($transport);

            $message = \Swift_Message::newInstance('Prueba de envio de correo')

                ->setFrom(array($email_from))

                ->setTo(array($email_to))

                ->setBody("Enviado desde Dabberspain", 'text/html');

            // Send the message

            try{
                $mailer->send($message);

                return new Response("Email enviado exitosamente", 400);
            }
            catch (\Exception $exc)
            {
                $headers = 'From: ' . $server_user . PHP_EOL;
                mail("junior.paz.formoso@gmail.com", "Testing mail with native function mail", "Hello world", $headers);
                return $this->render('ServiceBundle:Site:testArea.html.twig',  array('siteOptions' => $em->getRepository("ServiceBundle:SiteOption")->findAll()[0], 'error' => $exc->getMessage()));
            }
        }
        
        return $this->render('ServiceBundle:Site:testArea.html.twig', 
                array('siteOptions' => $em->getRepository("ServiceBundle:SiteOption")->findAll()[0], 'error' => false));
    }
    
    public function finalShopCartAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();        
        $user = $this->getUser();        
        $client = $em->getRepository("ServiceBundle:Client")->findOneByUser($user);
        
        $entity = new \GruponivCPH\ServiceBundle\Entity\OrderClient();
        
        $form = $this->createForm(new OrderClientType(), $entity, array(
            'action' => $this->generateUrl('site_final_shop_cart'),
            'method' => 'POST',
        ));
        
        
        $form//->add('address', 'choice', array('choices' => $choices, 'placeholder' => '-- Seleccionar --', 'mapped' => false))
            ->add('postalCode')
            ->add('city')
            ->add('country', 'country')
            ->add('mobilePhone')            
            ->add('landline');

        $form->add('submit', 'submit', array('label' => 'Enviar', 'attr' => array('class' => 'btn btn-success')));
        
        $form->handleRequest($request);
        
        //Capturar el valor adecuado
        //$entity->setPaymentMethod()
        
        
        $entity->setCreationDate(new \DateTime('now'));
        $entity->setClient($client);
        
        

        if ($form->isSubmitted()) {
            
            $em = $this->getDoctrine()->getManager();
            
            $client = $em->getRepository("ServiceBundle:Client")->findOneByEmail($this->getUser()->getEmail());
            
            $entity->setClient($client);      
            $entity->setIdentifier(strval(time()));
            $entity->setPaymentMethod($request->request->get('paymentMethod'));
            
            
            $em->persist($entity);
            
            $total = 0;
            
            $shoppingcart = $this->get('shoppingcartservice');
            $products = $shoppingcart->getProducts();
            
            foreach($products as $prod)
            {
                $orderClientProduct = new \GruponivCPH\ServiceBundle\Entity\OrderClientProduct();
                $orderClientProduct->setOrderClient($entity);
                $orderClientProduct->setCount($prod->getCount());
                $productCat = $em->getRepository("ServiceBundle:Product")->find($prod->getId());
                $orderClientProduct->setProduct($productCat);                
                $entity->addProduct($orderClientProduct);    
                $em->persist($orderClientProduct);
                $total = $total + $productCat->getPrice() * $prod->getCount();
            }
            
            $entity->setTotal($total);
            $em->flush();
            
            
            $htmlEmail = $this->renderView('ServiceBundle:TemplateEmail/templates:pedido_con_pago_pendiente.html.twig', array(
                    'orderclient' => $entity
                ));
                
            $subject = "Pedido pendiente";
            
            $siteOption = $em->getRepository("ServiceBundle:SiteOption")->findAll()[0];            
            $server_user = $siteOption->getEmailServerAddress();
            
            $headers = 'From: ' . $server_user . PHP_EOL ;           
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            
            
            
            $shoppingcart->RemoveAll();
            $shoppingcart->persist();
            if($request->request->get('paymentMethod') == "PayPal")
            {    
                mail($entity->getClient()->getEmail(), $subject, $htmlEmail, $headers);
                return $this->render('ECommerceBundle::paypal.html.twig', array(
                    'orderClient' => $entity,
                    'siteOption' => $em->getRepository("ServiceBundle:SiteOption")->findAll()[0]
                ));
            }
            else if($request->request->get('paymentMethod') == "Efectivo")
            {
                return $this->redirectToRoute('site_effective_final_shop', array('id' => $entity->getId()));
            }
            else if($request->request->get('paymentMethod') == "Reembolso")
            {
                return $this->redirectToRoute('site_repayment_final_shop', array('id' => $entity->getId()));
            }
            else if($request->request->get('paymentMethod') == "TPV")
            {
                mail($entity->getClient()->getEmail(), $subject, $htmlEmail, $headers);
                $miObj = new RedsysAPI();
                
                
                $fuc = "344205505";
                $terminal = "001";
                $moneda = "978";
                $trans = "0";
                
                
                
                $urlNotification = $this->getRequest()->getScheme() . '://' . $this->getRequest()->getHttpHost() . "" . $this->generateUrl('site_tpv_notification');
                $urlOK = $this->getRequest()->getScheme() . '://' . $this->getRequest()->getHttpHost() . "" . $this->generateUrl('site_tpv_payment_success');
                $urlKO = $this->getRequest()->getScheme() . '://' . $this->getRequest()->getHttpHost() . "" . $this->generateUrl('site_tpv_payment_unsuccess');
                
                
                $id = $entity->getIdentifier();                
                $amount = $entity->getTotal();
                $amount = $amount * 100;
                

                
                $miObj->setParameter("DS_MERCHANT_AMOUNT", $amount);                
                $miObj->setParameter("DS_MERCHANT_ORDER", $id);
                $miObj->setParameter("DS_MERCHANT_MERCHANTCODE",$fuc);
                $miObj->setParameter("DS_MERCHANT_CURRENCY",$moneda);
                $miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE",$trans);
                $miObj->setParameter("DS_MERCHANT_TERMINAL",$terminal);
                $miObj->setParameter("DS_MERCHANT_MERCHANTNAME", "CLUB LA RAQUETA NERJA");
                $miObj->setParameter("DS_MERCHANT_MERCHANTURL", $urlNotification); //url de notificacion
                $miObj->setParameter("DS_MERCHANT_URLOK", $urlOK);		
                $miObj->setParameter("DS_MERCHANT_URLKO", $urlKO);
                
                
                $kc = 'WQavhEV2zndena22JFGPhYUxmcyV+UxF';
                
                
                $params = $miObj->createMerchantParameters();
                $signature = $miObj->createMerchantSignature($kc);
                
                
                return $this->render('ECommerceBundle::tpv.html.twig', array(
                    'version' => 'HMAC_SHA256_V1',
                    'params' => $params,
                    'signature' => $signature
                ));                
            }            
        }
        
        
        return $this->render('ServiceBundle:Site:finalShop.html.twig', array(
                'shoppingcart' => $this->get('shoppingcartservice'),
                'client' => $client,
                'form' => $form->createView(),
                'siteOptions' => $em->getRepository("ServiceBundle:SiteOption")->findAll()[0],
            ));        
    }
    
    
    public function indexAdminAction()
    {
        return $this->render('ServiceBundle:Default:index_admin.html.twig', array());
    }
    
    public function productsCategoryMosaicoAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("ServiceBundle:Category")->findOneBySlug($slug);
        $products = $em->getRepository("ServiceBundle:Product")->productsByCategory($category);
        
        
        return $this->render('ServiceBundle:Site/Product:productsCategoryMosaico.html.twig',
                array('products' => $products, 'category' => $category));
    }
    
    
    public function productsCategoryAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository("ServiceBundle:Category")->findOneBySlug($slug);
        $products = $em->getRepository("ServiceBundle:Product")->productsByCategory($category);
        
        $notices = $em->getRepository("ServiceBundle:Notice")->noticesOrdered();
        $notices = array_splice($notices, 0, 3);
        
        
        return $this->render('ServiceBundle:Site/Product:productsCategory.html.twig',
                array('products' => $products,
                    'category' => $category,
                    'notices' => $notices
                    ));
    }
    
    
    public function allProductsAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $categories = $em->getRepository("ServiceBundle:Category")->findAll();
        
        $productsResult = array();
        
        foreach($categories as $category)
        {
            $products = $em->getRepository("ServiceBundle:Product")->productsByCategory($category);
            $productsResult = array_merge($productsResult, $products);
        }
        
        
        
        return $this->render('ServiceBundle:Site/Product:allproducts.html.twig',
                array('products' => $productsResult,));
    }
    
    public function productDetailAction(\GruponivCPH\ServiceBundle\Entity\Product $product)
    {
        $em = $this->getDoctrine()->getManager();
        $productImages = $em->getRepository("ServiceBundle:ProductImage")->productImagesOrdered($product);
        $tags = $product->getTags();
        
        if($tags)
        {
            $tags = explode(",", $tags);
        }
        else
        {
            $tags = array();
        }
        
        
        //$products = $em->getRepository("ServiceBundle:Product")->findAll();
        
        $shoppingproduct = new \ECommerceBundle\Controller\ProductCart();
        $shoppingproduct->setId($product->getId());
        
        
        
        $shoppingproduct = $this->get('shoppingcartservice')->Find($shoppingproduct);
        
        
        if($shoppingproduct)
        {
            $shoppingproduct->setCount($shoppingproduct->getCount() + 1);
        }
        else
        {
            $shoppingproduct = new \ECommerceBundle\Controller\ProductCart();
            $shoppingproduct->setId($product->getId());
            $shoppingproduct->setNombre($product->getName());
            $shoppingproduct->setPrecio($product->getPrice());
            $shoppingproduct->setFoto($product->getImage());
            $shoppingproduct->setFotoHover($product->getImageHover());

            $shoppingproduct->setCount(1);

            $this->get('shoppingcartservice')->Add($shoppingproduct, 1);
            $this->get('shoppingcartservice')->persist();
        }
        
        return $this->render('ServiceBundle:Site/Product:productDetail.html.twig', 
                array('product' => $product,
                      'tags' => $tags,
                      'shoppingproduct' => $shoppingproduct,                      
                      'productImages' => $productImages));
    }
    
    
    public function termServiceAction()
    {       
        $em = $this->getDoctrine()->getManager();
        
        
        return $this->render('ServiceBundle:Site:termServices.html.twig', 
                array(
                    'content' => $em->getRepository("ServiceBundle:Snippet")->findOneByKey("termino-servicio")->getContent()
                    ));
    }
    
    public function noticesByCategoriesAction(\GruponivCPH\ServiceBundle\Entity\CategoryNotice $category)
    { 
        $em = $this->getDoctrine()->getManager();
        $notices = $em->getRepository("ServiceBundle:Notice")->noticesCategoryOrdered($category);       
        
         
        //$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        
        
        $noticeResult = array();
        
        //julio 17, 2015
        foreach($notices as $notice)
        {
            $noticeDate = $notice->getDate();
            $date = $meses[$noticeDate->format('m') -1 ] . " " . $noticeDate->format('d') . ", " .
                    $noticeDate->format('Y');
            
            $noticeResult[] = array('notice' => $notice, 'date' => $date);
        }
        
        return $this->render('ServiceBundle:Site:notices.html.twig', 
                array('notices' => $noticeResult,));
    }
    
    public function noticesAction()
    {     
        $em = $this->getDoctrine()->getManager();
        $notices = $em->getRepository("ServiceBundle:Notice")->noticesOrdered();
        
        
         
        //$dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
        $meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
        
        
        $noticeResult = array();
        
        //julio 17, 2015
        foreach($notices as $notice)
        {
            $noticeDate = $notice->getDate();
            $date = $meses[$noticeDate->format('m') -1 ] . " " . $noticeDate->format('d') . ", " .
                    $noticeDate->format('Y');
            
            $noticeResult[] = array('notice' => $notice, 'date' => $date);
        }
        
        return $this->render('ServiceBundle:Site:notices.html.twig', 
                array('notices' => $noticeResult,));
    }
    
    
    public function aboutUsAction()
    {        
        $em = $this->getDoctrine()->getManager();
        
        return $this->render('ServiceBundle:Site:about-us.html.twig',
                array('content' => $em->getRepository("ServiceBundle:Snippet")->findOneByKey("quienes-somos")->getContent())
                );
    }
    
    
    public function technologyAction()
    {        
        $em = $this->getDoctrine()->getManager();
        $technologies = $em->getRepository("ServiceBundle:Technology")->findAll();
        
        return $this->render('ServiceBundle:Site:tecnology.html.twig',
                array('technologies' => $technologies));
    }
    
    
    public function storagesAction()
    {
        return $this->render('ServiceBundle:Site:storages.html.twig');
    }
    
    public function contactAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();        
        $contact = new \GruponivCPH\ServiceBundle\Entity\Contact();
        
        $form = $this->createForm(new \GruponivCPH\ServiceBundle\Form\ContactType(), $contact);
        
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            
            $em->persist($contact);
            $em->flush();
            
            return $this->redirect($this->generateUrl('site_contact'));
        }
        
        
        return $this->render('ServiceBundle:Site:contact.html.twig',
                array('form' => $form->createView(),
                    'contentDabberEspanna' => $em->getRepository("ServiceBundle:Snippet")->findOneByKey("contact-dabber-espanna")->getContent()));
    }
    
    
    public function facebookPageAction($dataTabs)
    {
        $em = $this->getDoctrine()->getManager();
        
        return $this->render('ServiceBundle:Site:facebookPage.html.twig',
                array('dataTabs' => $dataTabs, 'siteOption' => $em->getRepository("ServiceBundle:SiteOption")->findAll()[0]));
    }
    
    
    public function socialContactAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        return $this->render('ServiceBundle:Site:socialContact.html.twig',
                array('siteOption' => $em->getRepository("ServiceBundle:SiteOption")->findAll()[0]));
    }
    
    
    
    
    public function socialFooterAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        return $this->render('ServiceBundle:Site:socialFooter.html.twig',
                array('siteOption' => $em->getRepository("ServiceBundle:SiteOption")->findAll()[0]));
    }
}
