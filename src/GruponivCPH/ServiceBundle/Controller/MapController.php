<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\Banner;
use GruponivCPH\ServiceBundle\Form\BannerType;

/**
 * Banner controller.
 *
 */
class MapController extends Controller
{

  
    
    public function testAction()
    {
        return $this->render('ServiceBundle:Map:testing.html.twig');
    }
}
