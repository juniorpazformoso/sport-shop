<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\Carrier;
use GruponivCPH\ServiceBundle\Form\CarrierType;

/**
 * Carrier controller.
 *
 */
class CarrierController extends Controller
{
    
    private function getUploadsDir() {             
        return __DIR__.'/../../../../web/uploads';
    }

    /**
     * Lists all Carrier entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:Carrier')->findAll();
        
        $aaData = array();
        foreach ($entities as $ent) {
            $delete_form = $this->createDeleteForm($ent->getId())->createView();
            $action = $this->renderView('ServiceBundle:Carrier:actions.html.twig', array('delete_form' => $delete_form, 'entity_id' => $ent->getId(), 'entity_name' => ''));

            $aaData[] = array(
                'action'  => $action
            );
        }

        return $this->render('ServiceBundle:Carrier:index.html.twig', array(
            'entities' => $entities,
            'aaData' => $aaData
        ));
    }
    /**
     * Creates a new Carrier entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Carrier();
        
        $em = $this->getDoctrine()->getManager();
        
        
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            
            $namePicture =  time() . rand(1, 10000) .  '.' . $entity->getLogoFile()->getClientOriginalExtension();                
            $entity->setLogo($namePicture);                
            $entity->getLogoFile()->move($this->getUploadsDir(), $namePicture);
            
            
            $em->persist($entity);
            $em->flush();
            
            return $this->redirect($this->generateUrl('carrier'));
        }

        return $this->render('ServiceBundle:Carrier:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'localUnit' => $em->getRepository('ServiceBundle:LocalUnit')->findAll()[0]
        ));
    }

    /**
     * Creates a form to create a Carrier entity.
     *
     * @param Carrier $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Carrier $entity)
    {
        $form = $this->createForm(new CarrierType(), $entity, array(
            'action' => $this->generateUrl('carrier_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Carrier entity.
     *
     */
    public function newAction()
    {
        $entity = new Carrier();
        $form   = $this->createCreateForm($entity);
        
        $em = $this->getDoctrine()->getManager();

        return $this->render('ServiceBundle:Carrier:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'localUnit' => $em->getRepository('ServiceBundle:LocalUnit')->findAll()[0]
        ));
    }

    /**
     * Finds and displays a Carrier entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Carrier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carrier entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:Carrier:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Carrier entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Carrier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carrier entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:Carrier:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'localUnit' => $em->getRepository('ServiceBundle:LocalUnit')->findAll()[0]
        ));
    }

    /**
    * Creates a form to edit a Carrier entity.
    *
    * @param Carrier $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Carrier $entity)
    {
        $form = $this->createForm(new CarrierType(), $entity, array(
            'action' => $this->generateUrl('carrier_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));

        return $form;
    }
    /**
     * Edits an existing Carrier entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Carrier')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Carrier entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            if (!is_null($entity->getlogoFile())) {
                $namePicture =  time() . rand(1, 10000) .  '.' . $entity->getlogoFile()->getClientOriginalExtension();                
                $entity->setImage($namePicture);                
                $entity->getlogoFile()->move($this->getUploadsDir(), $namePicture); 
            }
            
            
            $em->flush();

            return $this->redirect($this->generateUrl('carrier'));
        }

        return $this->render('ServiceBundle:Carrier:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'localUnit' => $em->getRepository('ServiceBundle:LocalUnit')->findAll()[0]
        ));
    }
    /**
     * Deletes a Carrier entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:Carrier')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Carrier entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('carrier'));
    }

    /**
     * Creates a form to delete a Carrier entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('carrier_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
