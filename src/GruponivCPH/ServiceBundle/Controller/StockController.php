<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\LocalUnit;
use GruponivCPH\ServiceBundle\Form\LocalUnitType;

/**
 * LocalUnit controller.
 *
 */
class StockController extends Controller
{

    public function saveStockDataAction(Request $request)
    {        
        $em = $this->getDoctrine()->getManager();
        
        $session = $request->getSession();
            
        $provider = $request->request->get('provider');
        
        $shoppinCart  = $this->get('shoppingcartservice');
        $stocks = $shoppinCart->getProducts();
        
        //Actualizando el stock
        foreach($stocks as $stock)
        {
            $id = $stock->getId();
            $amountProduct = $stock->getCount();
            $stock = $em->getRepository("ServiceBundle:Stock")->find($id);
            $stock->setAmount($amountProduct + $stock->getAmount());
            $em->flush();
            
        }
        
        
        
        $provider = $em->getRepository("ServiceBundle:Provider")->find($provider);

        $supplyPayment = new \GruponivCPH\ServiceBundle\Entity\SupplyPayment();
        $supplyPayment->setProvider($provider);
        $supplyPayment->setDateSupply(new \DateTime('now'));
        
        $em->persist($supplyPayment);
        $em->flush();
                
        
        
      
        
        $products = $shoppinCart->getProducts();
            
        foreach($products as $prod)
        {                
            $supplyProduct = new \GruponivCPH\ServiceBundle\Entity\SupplyProduct();
            

            $stock = $em->getRepository("ServiceBundle:Stock")->find($prod->getId());

            $product = $stock->getProduct();
            $supplyProduct->setProduct($product);
            $supplyProduct->setSupplyPayment($supplyPayment);                
            $em->persist($supplyProduct);
            $em->flush();     
            
        
        }
        
        return $this->redirect($this->generateUrl('stock'));
    }
    
    
    public function providersAction()
    {
        $em = $this->getDoctrine()->getManager();

        $providers = $em->getRepository('ServiceBundle:Provider')->findAll();

        return $this->render('ServiceBundle:stock:providers.html.twig', array(
            'providers' => $providers,
        ));
    }
    
    public function processingStockAction(Request $request)
    {        
        
        $shoppinCart  = $this->get('shoppingcartservice');
        $products = $shoppinCart->getProducts();
        
        
        foreach($products as $product)
        {
            $currentCount = $request->request->get("stock_" . $product->getId());
            $product->setCount($currentCount);
            $shoppinCart->persist();
        }
        
        return $this->redirectToRoute('providers_index');
    }
    
    
    
    public function removeStockProductAction(Request $request)
    {
        $product = new \ECommerceBundle\Controller\ProductCart();
        $product->setId($request->request->get('id'));
        
        $shoppingcart = $this->get('shoppingcartservice');
        $shoppingcart->Remove($product);
        $this->get('shoppingcartservice')->persist();
        
        $items = json_encode(array('id' => $request->request->get('id')));
        
        return new Response($items, 200, array('Content-Type' => 'application/json'));        
    }
    
    
    public function stockSelectedAction()
    {
        return $this->render('ServiceBundle:stock:stock_selected.html.twig', 
                array('shoppingcart' => $this->get('shoppingcartservice'),)); 
    }
    
    public function stockingProductsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        
        $lengthStockProduct = $request->request->get('lengthStockProduct');
               

        for($i = 1; $i <= $lengthStockProduct; $i++)
        {
            $id = $request->request->get("stock_" . $i);
            $checked = $request->request->get("checked_" . $i);
            $stock = $em->getRepository("ServiceBundle:Stock")->find($id);
            $shoppinCart  = $this->get('shoppingcartservice');
            
            
            if($checked == "checked")
            {
                $product = $stock->getProduct();

                $shoppingproduct = new \ECommerceBundle\Controller\ProductCart();
                $shoppingproduct->setId($stock->getId());
                $shoppingproduct->setNombre($product->getName());
//                $shoppingproduct->setPrecio($product->getPriceProvider());
                
				if(!$shoppinCart->Exist($shoppingproduct))
                {
                    $shoppingproduct->setCount(9);
                }
				
				/*
                if($shoppinCart->Exist($shoppingproduct))
                {
                    $shoppingproduct->setCount(0);
                }
                else
                {
                    $shoppingproduct->setCount(1);
                }
				*/
				
                
                

                $shoppinCart->Add($shoppingproduct);
                $shoppinCart->persist();
                
            }
            else
            {             
                $product = new \ECommerceBundle\Controller\ProductCart();
                $product->setId($stock->getId());
                $shoppinCart->Remove($product);                
                $shoppinCart->persist();
            }
        }
        
        
        return $this->redirect($this->generateUrl('stock_selected'));
    }
    
    public function stocksByCategoryAction($id)
    {
        
        $em = $this->getDoctrine()->getManager();        
        
        $stocksByCategory = $em->getRepository("ServiceBundle:Stock")->stocksByCategory($id);
     
        return $this->render('ServiceBundle:stock:stockByCategory.html.twig', array(
            'stocksByCategory' => $stocksByCategory,
            'shoppingcart' => $this->get('shoppingcartservice'),
        )); 
    }
    
    
    public function categoriesAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        
        $categories = $em->createQuery("select c from ServiceBundle:Category c")->getResult();
        
        return $this->render('ServiceBundle:stock:fragments/categories.html.twig', array(
            'categories' => $categories,
        )); 
    }
    
    /**
     *
     */
    public function indexAction()
    {
        $this->get('shoppingcartservice')->RemoveAll();
        return $this->render('ServiceBundle:stock:index.html.twig', array(
            
        ));
    }
}
