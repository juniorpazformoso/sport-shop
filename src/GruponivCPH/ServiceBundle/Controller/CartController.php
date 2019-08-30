<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\Contact;
use GruponivCPH\ServiceBundle\Form\ContactType;

/**
 * Contact controller.
 *
 */
class CartController extends Controller
{
 
    
    public function globalInfoAction()
    {
        $ammount = $this->get('shoppingcartservice')->getAmmount();
        $count = $this->get('shoppingcartservice')->getCount();
        
        $items = array('ammount' => $ammount, 'count' => $count);
        $items = json_encode($items);
        return new Response($items, 200);
    }
    
    
    public function shoppingCartVisibleAction()
    {        
        return $this->render('ServiceBundle:Site/Cart:shoppingCartVisible.html.twig',
                array('shoppingcart' => $this->get('shoppingcartservice')));
    }
    
    
    public function shoppingCartHeaderAction()
    {        
        return $this->render('ServiceBundle:Site/Cart:shoppingCartHeader.html.twig',
                array('shoppingcart' => $this->get('shoppingcartservice')));
    }
    
    
    public function listShoppingCartAction()
    {
        return $this->render('ServiceBundle:Site/Cart:listProducts.html.twig', array(
                'shoppingcart' => $this->get('shoppingcartservice'),
            ));        
    }
    
    public function deleteAction($id)
    {
        $product = new \ECommerceBundle\Controller\ProductCart();
        $product->setId($id);
        $this->get('shoppingcartservice')->Remove($product);
        $this->get('shoppingcartservice')->persist();
        
        $item = array('success' => true);
        $item = json_encode($item);
        
        return new Response($item, 200);
        //return $this->redirect($this->generateUrl('system_propaganda_listarcarritocompras'));
    }
    
    public function addToCartAction(Request $request)
    {
        $id = $request->request->get('id');
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("ServiceBundle:Product")->find($id);

        if (!$product) {
            throw $this->createNotFoundException("No se pudo encontrar el producto a partir del parámetro proporcionado");
        }

        $shoppingproduct = new \ECommerceBundle\Controller\ProductCart();
        $shoppingproduct->setId($product->getId());
        $shoppingproduct->setNombre($product->getName());
        $shoppingproduct->setPrecio($product->getPrice());
        $shoppingproduct->setFoto($product->getImage());
        $shoppingproduct->setFotoHover($product->getImageHover());
        
        $shoppingproduct->setCount(1);

        $this->get('shoppingcartservice')->Add($shoppingproduct, 1);
        $this->get('shoppingcartservice')->persist();
        
        return $this->render('ServiceBundle:Site/Cart:addToCartProduct.html.twig', array(
                'shoppingcart' => $this->get('shoppingcartservice'),
                'shoppingproduct' => $shoppingproduct,            
                'product' => $product,
            ));
    }
    
    public function updateQuantityProductAction(Request $request)
    {
        $productId = $request->request->get('id');
        $quantity = $request->request->get('quantity');
        $em = $this->getDoctrine()->getManager();
        
        $productDB = $em->getRepository("ServiceBundle:Product")->find((int)$productId);
        
        $shoppingproduct = new \ECommerceBundle\Controller\ProductCart();
        $shoppingproduct->setId($productId);
            
        if($quantity == 0)
        {
            $this->get('shoppingcartservice')->Remove($shoppingproduct);
            $this->get('shoppingcartservice')->persist();
        }
        else if($quantity > 0)
        {            
            $product = $this->get('shoppingcartservice')->Find($shoppingproduct);
            
            if($product)
            {
                $product->setCount($quantity);
                $this->get('shoppingcartservice')->Update($product);
                $this->get('shoppingcartservice')->persist();
            }
            else 
            {
                $shoppingproduct = new \ECommerceBundle\Controller\ProductCart();
                $shoppingproduct->setId($productId);
                $shoppingproduct->setNombre($productDB->getName());
                $shoppingproduct->setPrecio($productDB->getPrice());
                $shoppingproduct->setFoto($productDB->getImage());
                $shoppingproduct->setFotoHover($productDB->getImageHover());

                $shoppingproduct->setCount($quantity);

                $this->get('shoppingcartservice')->Add($shoppingproduct, 1);
                $this->get('shoppingcartservice')->persist();
            }
            
        }
        
        $item = array('success' => true);
        $item = json_encode($item);
        
        return new Response($item, 200);
    }
    
    public function totalAmountCartAction()
    {
        $totalAmount = $this->get('shoppingcartservice')->getAmmount();
        
        $item = array('totalAmount' => $totalAmount);
        $item = json_encode($item);
        
        return new Response($item, 200);
    }
}
