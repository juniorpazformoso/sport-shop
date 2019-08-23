<?php
namespace ECommerceBundle\Controller;


interface IShoppingCart {
    function Add(ProductCart $product);
    function Remove(ProductCart $product);
    function Update(ProductCart $product);
    function persist();

    function getCount();
    function getAmmount();
    function getProducts();
}