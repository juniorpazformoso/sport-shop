<?php
namespace ECommerceBundle\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class SessionShoppingCart implements IShoppingCart {
    private $session;
    private $products;
    private $session_id = 'dabberspain_shoppingcart_products';

    public function __construct(\Symfony\Component\HttpFoundation\Session\Session $session)
    {
        $this->session = $session;

        if ($this->session->has($this->session_id)) {
            $this->products = unserialize($this->session->get($this->session_id));
        }
        else {
            $this->products = array();
        }
    }
    
    public function RemoveAll()
    {
        foreach($this->getProducts() as $product)
        {
            unset($this->products[$product->getId()]);
        }
        
        $this->session->remove($this->session_id);
    }
    
    public function Exist(ProductCart $product)
    {
        return array_key_exists($product->getId(), $this->products);
    }

    public function Add(ProductCart $product)
    {
        if (array_key_exists($product->getId(), $this->products)) {
            $temp = $this->products[$product->getId()];
            $temp->setCount($temp->getCount() + $product->getCount());
        }
        else {
            $this->products[$product->getId()] = $product;
        }
    }
    
    

    public function Remove(ProductCart $product)
    {
        unset($this->products[$product->getId()]);

        if ($this->getCount() == 0) {
            $this->session->remove($this->session_id);
        }
    }

    public function Update(ProductCart $product)
    {
        if (isset($this->products[$product->getId()])) {
            $this->products[$product->getId()] = $product;
        }
    }
    
    public function Find(ProductCart $product)
    {
        if (isset($this->products[$product->getId()])) {
            return $this->products[$product->getId()];      
        }
    }

    public function getCount()
    {
        $count = 0;

        foreach ($this->products as $product) {
            $count += $product->getCount();
        }

        return $count;
    }

    public function getAmmount()
    {
        $price = 0;

        foreach ($this->products as $product) {
            $price += $product->getAmmount();
        }

        return $price;
        //return number_format($price, 2);
    }

    public function getProducts()
    {
        return $this->products;
    }

    public function persist() {
        $this->session->set($this->session_id, serialize($this->products));
    }
}