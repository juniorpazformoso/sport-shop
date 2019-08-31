<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Acme\DemoBundle\Form\ContactType;
use GruponivCPH\ServiceBundle\Entity\Comment;
use GruponivCPH\ServiceBundle\Entity\Stat;
use GruponivCPH\ServiceBundle\Form\CommentPostType;
use GruponivCPH\ServiceBundle\Form\CommentType;
use GruponivCPH\ServiceBundle\Form\ContactoType;
use Innocead\CaptchaBundle\Captcha;
use Innocead\CaptchaBundle\Form\Type\CaptchaType;
use Innocead\CaptchaBundle\Validator\Constraints\CaptchaValidator;
use Knp\Component\Pager\Paginator;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Controller\SecurityController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use GruponivCPH\UserBundle\Entity\User;
use GruponivCPH\UserBundle\Form\UserType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Model\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{
    

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $menus = $em->createQuery("select c from ServiceBundle:Category c where c.belong is null")->getResult();
        $sliders = $em->getRepository("ServiceBundle:Banner")->findAll();
        
        $products = $em->getRepository("ServiceBundle:Product")->findAll();
        
        return $this->render('ServiceBundle:Default:index.html.twig',
                array('menus' => $menus, 
                    'sliders' => $sliders,
                    'siteOption' => $em->getRepository("ServiceBundle:SiteOption")->findAll()[0],
                    'shoppingcart' => $this->get('shoppingcartservice'),
                    'products' => $products));
    }
    
   
    
    

    public function categoryAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $stat = new Stat();
        $stat->setUrl($this->generateUrl('front_main_category', array('id'=>$id)));
        $stat->setDateAt(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($stat);
        $em->flush();

        $category = $em->getRepository("ServiceBundle:Category")->find($id);
        $cats = $em->createQuery("select c from ServiceBundle:Category c where c.belong is null order by c.order")->getResult();
        $categories = array();
        foreach($cats as $cat)
        {
            $categories[] = array(
                'active' =>$cat->getId() == ($category->getBelong() ? $category->getBelong()->getId() : $category->getId()) ? 'activa' : '',
                'entity' => $cat,
            );
        }

        $subcatsquery = $em->createQuery("select c from ServiceBundle:Category c where c.belong = :catid order by c.order");
        $subcatsquery->setParameter("catid", $id);
        $subcats = $subcatsquery->getResult();

        $articleArray = array();

        $query = $category->getSortElements() == 1 ? $em->createQuery("select a from ServiceBundle:Article a where a.category = :cat order by a.title asc") : $em->createQuery("select a from ServiceBundle:Article a where a.category = :cat order by a.dateCreated desc");
        $query->setParameter("cat", $category->getId());
        $articles = $query->getResult();

        foreach($articles as $art)
        {
            $articleArray[] = array(
                'article' => $art,
                'gallery' => unserialize($art->getPath())
            );
        }

        foreach($category->getSubCategories() as $subcat)
        {
            $query = $subcat->getSortElements() == 1 ? $em->createQuery("select a from ServiceBundle:Article a where a.category = :cat order by a.title asc") : $em->createQuery("select a from ServiceBundle:Article a where a.category = :cat order by a.dateCreated desc");
            $query->setParameter("cat", $subcat->getId());
            $articles = $query->getResult();

            foreach($articles as $art)
            {
                $articleArray[] = array(
                    'article' => $art,
                    'gallery' => unserialize($art->getPath())
                );
            }
        }

        if($category->getShowGrouped())
            $pagination = $this->get('knp_paginator')->paginate($articleArray, $request->get('page', 1), count($articleArray));
        else
            $pagination = $this->get('knp_paginator')->paginate($articleArray, $request->get('page', 1), 5);

        return $this->render('ServiceBundle:Default:front_category.html.twig', array(
            'category' => $category,
            'categories' => $categories,
            'subcategories' => $subcats,
            'articles' => $articleArray,
            'pagination' => $pagination,
        ));
    }

    public function articleAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('ServiceBundle:Article')->find($id);

        $category = $em->getRepository("ServiceBundle:Category")->find($article->getCategory());
        $cats = $em->createQuery("select c from ServiceBundle:Category c where c.belong is null order by c.order")->getResult();
        $categories = array();
        foreach($cats as $cat)
        {
            $categories[] = array(
                'active' =>$cat->getId() == ($category->getBelong() ? $category->getBelong()->getId() : $category->getId()) ? 'activa' : '',
                'entity' => $cat,
            );
        }

        foreach($category->getSubCategories() as $subcat)
        {
            $query = $em->createQuery("select a from ServiceBundle:Article a where a.category = :cat");
            $query->setParameter("cat", $subcat->getId());
            $articles = $query->getResult();

            foreach($articles as $art)
            {
                $articleArray[] = array(
                    'article' => $art
                );
            }
        }

        return $this->render('ServiceBundle:Default:front_article.html.twig', array(
            'category' => $category,
            'categories' => $categories,
            'article' => $article,
            'gallery' => unserialize($article->getPath())
        ));
    }

    public function contactAction()
    {
        $em = $this->getDoctrine()->getManager();

        $stat = new Stat();
        $stat->setUrl($this->generateUrl('front_contact'));
        $stat->setDateAt(new \DateTime());

        $em = $this->getDoctrine()->getManager();
        $em->persist($stat);
        $em->flush();

        //$category = $em->getRepository("ServiceBundle:Category")->find($article->getCategory());
        $cats = $em->createQuery("select c from ServiceBundle:Category c where c.belong is null order by c.order")->getResult();
        $categories = array();
        foreach($cats as $cat)
        {
            $categories[] = array(
                'active' => '',
                'entity' => $cat,
            );
        }

        $captcha = new \GruponivCPH\ServiceBundle\Entity\Captcha();
        $contact = $em->getRepository('ServiceBundle:SecondaryText')->find(4);

        return $this->render('ServiceBundle:Default:front_contact.html.twig', array(
            'categories' => $categories,
            'contact' => $contact,
            'form_captcha' => $this->createCaptchaForm($captcha)->createView()
        ));
    }

    public function createCaptchaForm(\GruponivCPH\ServiceBundle\Entity\Captcha $captcha) {
        $form_captcha = $this->createForm(new \GruponivCPH\ServiceBundle\Form\CaptchaType(), $captcha, array(
            'action' => $this->generateUrl('front_contact_post', array()),
            'method' => 'POST',
        ));
        $form_captcha->add('captcha', 'innocead_captcha');

        return $form_captcha;
    }

    public function contactPostAction(Request $request)
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $body = $_POST['body'];
        $captcha_text = $_POST['captcha'];

        $captchaService = $this->get('innocead_captcha');

        if($captchaService->isValid($captcha_text)) {
            $message = \Swift_Message::newInstance()
                ->setSubject('Nueva petición de contacto')
                ->setFrom($this->container->getParameter('swiftmailer.from'))
                ->setTo($this->container->getParameter('swiftmailer.from'))
                ->setBody("Hola:\n Se ha creado una nueva petición de contacto por " . $email . "\n\nContenido del mensaje:\n" . $body);
            $this->get('mailer')->send($message);

            $this->get('session')->getFlashBag()->add('info',
                $this->get('translator')->trans('contact.success')
            );
        }
        else {
            $this->get('session')->getFlashBag()->add('error',
                $this->get('translator')->trans('contact.error')
            );
        }

        return $this->redirect($this->generateUrl('front_contact'));
    }

    public function indexAdminAction()
    {
        $em = $this->getDoctrine()->getManager();

        /*$fecha = new \DateTime('Ymd');
        $consulta = $em->createQuery("SELECT s FROM ServiceBundle:Stat s WHERE s = '$fecha'");
        $stats = $consulta->getResult();*/
        $user = $this->getUser();
        
        //print_r($user->getRoles());
        //return new Response("Ca", 400);
        //return $this->redirect($this->generateUrl('service_account_client'));
        
        return $this->render('ServiceBundle:Default:index_admin.html.twig', array());
    }
}
