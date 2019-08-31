<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\Notice;
use GruponivCPH\ServiceBundle\Form\NoticeType;

/**
 * Notice controller.
 *
 */
class NoticeController extends Controller
{

    private function getUploadsDir() {             
        return __DIR__.'/../../../../web/uploads';
    }
    
    /**
     * Lists all Notice entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:Notice')->findAll();

        $aaData = array();
        foreach ($entities as $ent) {
            $delete_form = $this->createDeleteForm($ent->getId())->createView();
            $action = $this->renderView('ServiceBundle:Notice:actions.html.twig', array('delete_form' => $delete_form, 'entity_id' => $ent->getId(), 'entity_name' => $ent->getTitle()));

            $aaData[] = array(
                'action'  => $action
            );
        }
        
        return $this->render('ServiceBundle:Notice:index.html.twig', array(
            'entities' => $entities,
            'aaData' => $aaData,
        ));
    }
    /**
     * Creates a new Notice entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Notice();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $entity->setDate(new \DateTime('now'));
            
            $namePicture =  time() . rand(1, 10000) .  '.' . $entity->getPictureFile()->getClientOriginalExtension();                
            $entity->setImage($namePicture);                
            $entity->getPictureFile()->move($this->getUploadsDir(), $namePicture);
            
            
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('notice', 'Creada satisfactoriamente');

            return $this->redirect($this->generateUrl('notice'));
        }

        return $this->render('ServiceBundle:Notice:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Notice entity.
     *
     * @param Notice $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Notice $entity)
    {
        $form = $this->createForm(new NoticeType(), $entity, array(
            'action' => $this->generateUrl('notice_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Notice entity.
     *
     */
    public function newAction()
    {
        $entity = new Notice();
        $form   = $this->createCreateForm($entity);

        return $this->render('ServiceBundle:Notice:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Notice entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Notice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Notice entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:Notice:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Notice entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Notice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Notice entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:Notice:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Notice entity.
    *
    * @param Notice $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Notice $entity)
    {
        $form = $this->createForm(new NoticeType(), $entity, array(
            'action' => $this->generateUrl('notice_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Modificar'));

        return $form;
    }
    /**
     * Edits an existing Notice entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Notice')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Notice entity.');
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
            
            $this->get('session')->getFlashBag()->add('notice', 'Modificada satisfactoriamente');
            $em->flush();

            return $this->redirect($this->generateUrl('notice'));
        }

        return $this->render('ServiceBundle:Notice:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Notice entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:Notice')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Notice entity.');
            }

            $this->get('session')->getFlashBag()->add('notice', 'Eliminada satisfactoriamente');
            
            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('notice'));
    }

    /**
     * Creates a form to delete a Notice entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('notice_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
