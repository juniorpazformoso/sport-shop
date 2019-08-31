<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\Product;
use GruponivCPH\ServiceBundle\Form\ProductType;
use GruponivCPH\ServiceBundle\upload\Uploader;


ini_set('upload_max_filesize', '1024M');
ini_set('post_max_size', '1024M');
ini_set('memory_limit', '2048M');
ini_set('max_input_time', -1);
ini_set('max_execution_time',-1);


/**
 * Product controller.
 *
 */
class ProductController extends Controller
{

    private function getUploadsDir() {             
        return __DIR__.'/../../../../web/uploads';
    }
    
    /**
     * Lists all Product entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:Product')->findAll();
        
        $aaData = array();
        foreach ($entities as $ent) {
            $delete_form = $this->createDeleteForm($ent->getId())->createView();
            $action = $this->renderView('ServiceBundle:Product:actions.html.twig', array('delete_form' => $delete_form, 'entity_id' => $ent->getId(), 'entity_name' => $ent->getName()));

            $aaData[] = array(
                'action'  => $action,
                'aaData' => $aaData,
            );
        }


        return $this->render('ServiceBundle:Product:index.html.twig', array(
            'entities' => $entities,
            'aaData' => $aaData,
        ));
    }
    /**
     * Creates a new Product entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Product();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $namePicture =  time() . rand(1, 10000) .  '.' . $entity->getPictureFile()->getClientOriginalExtension();                
            $entity->setImage($namePicture);                
            $entity->getPictureFile()->move($this->getUploadsDir(), $namePicture);
            
            
            $namePicture =  time() . rand(1, 10000) .  '.' . $entity->getPictureHoverFile()->getClientOriginalExtension();                
            $entity->setImageHover($namePicture);                
            $entity->getPictureHoverFile()->move($this->getUploadsDir(), $namePicture);    
            
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
			
			$stock = new \GruponivCPH\ServiceBundle\Entity\Stock();
            $stock->setAmount(0);            
            $stock->setProduct($entity);
            $em->persist($stock);
            

            $this->get('session')->getFlashBag()->add('notice', 'Insertado satisfactoriamente');
            
            return $this->redirect($this->generateUrl('product'));
        }

        return $this->render('ServiceBundle:Product:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Product entity.
     *
     * @param Product $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Product $entity)
    {
        $form = $this->createForm(new ProductType(), $entity, array(
            'action' => $this->generateUrl('product_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Product entity.
     *
     */
    public function newAction()
    {
        $entity = new Product();
        $form   = $this->createCreateForm($entity);

        return $this->render('ServiceBundle:Product:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    
    public function removeImageAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $productImage = $em->getRepository("ServiceBundle:ProductImage")->findOneByImage($_POST['file']);
        $em->remove($productImage);
        $em->flush();
        
        $file = $this->getUploadsDir() . "/productImages/" . $_POST['file'];
        
        
        if(file_exists($file))
        {
            @unlink($file); 
        }
        
        $items = array();
        $items = json_encode($items);
        return new Response($items, 200, array('Content-Type' => 'application/json'));
    }
    
    
    public function removeAllImageSliderAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("ServiceBundle:Product")->find($id);
        
        $productImages = $product->getProductImages();
        
        foreach($productImages as $prodImg)
        {            
            $file = $this->getUploadsDir() . "/productImages/" . $prodImg->getImage();
            
            if(file_exists($file))
            {
                @unlink($file); 
            }
        
            $em->remove($prodImg);
            $em->flush();
        }
        
                
        return $this->redirectToRoute('product');
    }
    
    public function uploadProductImageAction($idProduct)
    {     
        $em = $this->getDoctrine()->getManager();
        $product = $em->getRepository("ServiceBundle:Product")->find($idProduct);
        
        $productImage = new \GruponivCPH\ServiceBundle\Entity\ProductImage();
        $productImage->setProduct($product);    
        
        
        $nameFileData = explode(".", $_FILES['files']['name'][0]);
        $nameFile = $nameFileData[0];
        $nameFile = $nameFile . "_" . time() . "." . $nameFileData[1];
        $productImage->setImage($nameFile);//$_FILES['files']['name'][0]);

        
        $em->persist($productImage);
        $em->flush();
        
        $uploader = new Uploader();
        $uploader->upload($_FILES['files'], $nameFile, array(
            'limit' => 200, //Maximum Limit of files. {null, Number}
            'maxSize' => 200, //Maximum Size of files {null, Number(in MB's)}
            'extensions' => null, //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
            'required' => false, //Minimum one file is required for upload {Boolean}
            'uploadDir' => $this->getUploadsDir() .  "/productImages/", //Upload directory {String}
            'title' => array('name'), //New file name {null, String, Array} *please read documentation in README.md
            'name' => array('name'),
            'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
            'perms' => null, //Uploaded file permisions {null, Number}
            'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
            'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
            'onSuccess' => null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
            'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
            'onComplete' => null, //A callback function name to be called when upload is complete | ($file) | Callback
            'onRemove' => 'onFilesRemoveCallback' //A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
        ));

        $items = array();
        $items = json_encode($items);
        return new Response($items, 200, array('Content-Type' => 'application/json'));
    }
    
    
    /**
     * Finds and displays a Image Product entity.
     *
     */
    public function imageProductAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Product')->find($id);       

        return $this->render('ServiceBundle:Product:imageProduct.html.twig', array(
            'product' => $entity,
        ));
    }
    
    
    /**
     * Finds and displays a Product entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:Product:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:Product:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Product entity.
    *
    * @param Product $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Product $entity)
    {
        $form = $this->createForm(new ProductType(), $entity, array(
            'action' => $this->generateUrl('product_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));

        return $form;
    }
    /**
     * Edits an existing Product entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            if (!is_null($entity->getPictureFile())) {
                $namePicture =  time() . rand(1, 10000) .  '.' . $entity->getPictureFile()->getClientOriginalExtension();                
                $entity->setImage($namePicture);                
                $entity->getPictureFile()->move($this->getUploadsDir(), $namePicture);    
            }
            
            
            if (!is_null($entity->getPictureFile())) {
                $namePicture =  time() . rand(1, 10000) .  '.' . $entity->getPictureHoverFile()->getClientOriginalExtension();                
                $entity->setImageHover($namePicture);                
                $entity->getPictureHoverFile()->move($this->getUploadsDir(), $namePicture);    
            }
            
            
            
            
            
            $this->get('session')->getFlashBag()->add('notice', 'Modificado satisfactoriamente');
            
            $em->flush();

            return $this->redirect($this->generateUrl('product'));
        }

        return $this->render('ServiceBundle:Product:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    
    function deleteDirectory($dir) {
        if(!$dh = @opendir($dir)) return;
        while (false !== ($current = readdir($dh))) {
            if($current != '.' && $current != '..') {
                echo 'Se ha borrado el archivo '.$dir.'/'.$current.'<br/>';
                if (!@unlink($dir.'/'.$current)) 
                    deleteDirectory($dir.'/'.$current);
            }       
        }
        closedir($dh);
        
        @rmdir($dir);
    }


    /**
     * Deletes a Product entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:Product')->find($id);
            
            @unlink($this->getUploadsDir() . "/" . $entity->getImage());
            @unlink($this->getUploadsDir() . "/" . $entity->getImageHover());
            
            $productImages = $entity->getProductImages();
            
            foreach($productImages as $prodImg)
            {            
                $file = $this->getUploadsDir() . "/productImages/" . $prodImg->getImage();

                if(file_exists($file))
                {
                    @unlink($file); 
                }

                $em->remove($prodImg);
                $em->flush();
            }
            //$this->deleteDirectory($this->getUploadsDir() . "/productImages");

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Product entity.');
            }

            $this->get('session')->getFlashBag()->add('notice', 'Eliminado satisfactoriamente');
            
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('product'));
    }

    /**
     * Creates a form to delete a Product entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
