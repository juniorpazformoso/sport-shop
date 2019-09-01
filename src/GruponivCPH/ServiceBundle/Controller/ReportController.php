<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\OrderClient;
use GruponivCPH\ServiceBundle\Form\OrderClientType;
use Symfony\Component\HttpFoundation\Response;


class ReportController extends Controller
{
    
    private function getUploadsDir() {             
        return __DIR__.'/../../../../web/uploads';
    }
    
    
    
    public function sellsAction(Request $request)
    {
        $form = $this->createFormBuilder()
                ->add('startDate', 'date', array('attr'=>array('class'=>'form-control'),  'label' => 'Fecha', 
                    'widget' => 'single_text', 'format' => 'dd/MM/yyyy'))
                ->add('endDate', 'date', array('attr'=>array('class'=>'form-control'),  'label' => 'Fecha', 
                    'widget' => 'single_text', 'format' => 'dd/MM/yyyy'))
                ->add('Export', 'submit', array('label' => 'Exportar', 'attr' => array('class' => 'btn btn-success')));
        
        $form = $form->getForm();
        
        $form->handleRequest($request);
        
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            
            $startDate = $form->get('startDate')->getData();
            $endDate = $form->get('endDate')->getData();
            
        
            $startDate = new \DateTime($startDate->format("Y-m-d") . " 00:00:00");
            $endDate = new \DateTime($endDate->format("Y-m-d") . " 23:59:59");
            
            
            $orderClients = $em->getRepository("ServiceBundle:OrderClient")->findBetweenDates($startDate, $endDate);
                
            $result = array();
            
            foreach($orderClients as $order)
            {                
                $totalBox = 0;
                
                $ordersByDate = $em->getRepository("ServiceBundle:OrderClient")
                                   ->findByCreationDate($order->getCreationDate());

                
                foreach($ordersByDate as $order){
                    $totalBox = $totalBox + $order->getTotal();
                }
                
                
                $baseIMP = round($totalBox/1.1, 2);
                $iva = $totalBox - $baseIMP;
                $closeDate = $order->getCreationDate()->format("d/m/Y");
                
                $result[] = array("date" => $closeDate, "boxtotal"  => $totalBox . ' €', "baseimp" => $baseIMP . ' €', "iva" => $iva . ' €');
            }
        
        
            $export = $this->get('export.excel')->setNameOfSheet("Facturación");


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

            $export->writeFullTable($result, array('date' => 'FECHA', 'boxtotal' => 'TOTAL', 'baseimp' => 'BASE IMP',
                 "iva" => "IVA"), $estilo, array(15, 15, 15, 15));
            
            $export->writeExport($this->getUploadsDir() . "/facturacion");

            $path = $this->getUploadsDir() . "/"  . "facturacion.xls";
            $content = file_get_contents($path);

            $response = new Response();

            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Disposition', 'attachment;filename="'. "facturacion.xls");

            $response->setContent($content);
            return $response;
        }
        
        return $this->render('ServiceBundle:report:invoiceInform.html.twig', array(
            'form' => $form->createView()
        ));
        
    }
}
