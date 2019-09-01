<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\Technology;
use GruponivCPH\ServiceBundle\Form\TechnologyType;

/**
 * Technology controller.
 *
 */
class TechnologyController extends Controller
{

    private function getUploadsDir() {             
        return __DIR__.'/../../../../web/uploads';
    }
    
    /**
     * Lists all Technology entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:Technology')->findAll();
        
        $aaData = array();
        foreach ($entities as $ent) {
            $delete_form = $this->createDeleteForm($ent->getId())->createView();
            $action = $this->renderView('ServiceBundle:Technology:actions.html.twig', array('delete_form' => $delete_form, 'entity_id' => $ent->getId(), 'entity_name' => $ent->getTitle()));

            $aaData[] = array(
                'action'  => $action
            );
        }

        return $this->render('ServiceBundle:Technology:index.html.twig', array(
            'entities' => $entities,
            'aaData' => $aaData
        ));
    }
    /**
     * Creates a new Technology entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Technology();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $namePicture =  time() . rand(1, 10000) .  '.' . $entity->getImageFile()->getClientOriginalExtension();                
            $entity->setImage($namePicture);                
            $entity->getImageFile()->move($this->getUploadsDir(), $namePicture);    
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Insertada satisfactoriamente');
            
            return $this->redirect($this->generateUrl('technology'));
        }

        return $this->render('ServiceBundle:Technology:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Technology entity.
     *
     * @param Technology $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Technology $entity)
    {
        $form = $this->createForm(new TechnologyType(), $entity, array(
            'action' => $this->generateUrl('technology_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Technology entity.
     *
     */
    public function newAction()
    {
        $entity = new Technology();
        $form   = $this->createCreateForm($entity);

        return $this->render('ServiceBundle:Technology:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Technology entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Technology')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technology entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:Technology:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Technology entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Technology')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technology entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:Technology:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Technology entity.
    *
    * @param Technology $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Technology $entity)
    {
        $form = $this->createForm(new TechnologyType(), $entity, array(
            'action' => $this->generateUrl('technology_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));

        return $form;
    }
    /**
     * Edits an existing Technology entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Technology')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Technology entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            if (!is_null($entity->getImageFile())) {
                $namePicture =  time() . rand(1, 10000) .  '.' . $entity->getImageFile()->getClientOriginalExtension();                
                $entity->setImage($namePicture);                
                $entity->getImageFile()->move($this->getUploadsDir(), $namePicture);    
            }
            
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Modificada satisfactoriamente');
            
            return $this->redirect($this->generateUrl('technology'));
        }

        return $this->render('ServiceBundle:Technology:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Technology entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:Technology')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Technology entity.');
            }

            $this->get('session')->getFlashBag()->add('notice', 'Eliminada satisfactoriamente');
            
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('technology'));
    }

    /**
     * Creates a form to delete a Technology entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('technology_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
