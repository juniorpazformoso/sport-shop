<?php

namespace GruponivCPH\ServiceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use GruponivCPH\ServiceBundle\Entity\Category;
use GruponivCPH\ServiceBundle\Form\CategoryType;
use Symfony\Component\HttpFoundation\Response;

/**
 * Category controller.
 *
 */
class CategoryController extends Controller
{

    /**
     * Lists all Category entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('ServiceBundle:Category')->findAll();

        $aaData = array();
        foreach ($entities as $ent) {
            $delete_form = $this->createDeleteForm($ent->getId())->createView();
            $action = $this->renderView('ServiceBundle:Category:actions.html.twig', array('delete_form' => $delete_form, 'entity_id' => $ent->getId(), 'entity_name' => $ent->getTitle()));

            $aaData[] = array(
                'action'  => $action
            );
        }

        return $this->render('ServiceBundle:Category:index.html.twig', array(
            'entities' => $entities,
            'aaData' => $aaData,
        ));
    }

    /**
     * Event triggered where Category changes on Dropdown component.
     *
     */
    public function changeAction()
    {
        $em = $this->getDoctrine()->getManager();

        $id = $this->container->get('request')->get('opt');
        $entity = $em->getRepository('ServiceBundle:Category')->find($id);

        $aaData = array();
        if($entity) {
            $query = $em->createQuery("select c from ServiceBundle:Category c where c.belong = :catid");
            $query->setParameter('catid', $entity->getId());
            $inner_categories = $query->getResult();

            $aaData[0]["max"] = count($inner_categories) == 0 ? 1 : count($inner_categories) + 1;
        }
        else {
            $aaData[0]["max"] = count($em->createQuery("select c from ServiceBundle:Category c where c.belong is null")->getResult()) + 1;
        }

        $resp = new Response();
        $resp->setContent(json_encode($aaData));
        return $resp;
    }

    /**
     * Creates a new Category entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Category();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity->setSlug(\GruponivCPH\ServiceBundle\Util\Util::getSlug($entity->getTitle(), "_"));
            
            $em->persist($entity);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('notice', 'Insertada satisfactoriamente');
            
            
            return $this->redirect($this->generateUrl('category'));
        }

        return $this->render('ServiceBundle:Category:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Category entity.
     *
     * @param Category $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Category $entity)
    {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('category_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new Category entity.
     *
     */
    public function newAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = new Category();
        
        $form   = $this->createCreateForm($entity);

        $categories = $em->createQuery("select c from ServiceBundle:Category c where c.belong is null")->getResult();

        return $this->render('ServiceBundle:Category:new.html.twig', array(
            'entity' => $entity,
            'categories' => $categories,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Category entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Category')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }

        // reload in different language
        $entity->setTranslatableLocale($this->getRequest()->getLocale());
        $em->refresh($entity);

        $repository = $em->getRepository('Gedmo\Translatable\Entity\Translation');
        $translations = $repository->findTranslations($entity);

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ServiceBundle:Category:show.html.twig', array(
            'entity'      => $entity,
            'translations' => $translations,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Category entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Category')->find($id);
        
        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Category entity.');
        }
        

        return $this->render('ServiceBundle:Category:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Category entity.
    *
    * @param Category $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Category $entity)
    {
        $form = $this->createForm(new CategoryType(), $entity, array(
            'action' => $this->generateUrl('category_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }
    /**
     * Edits an existing Category entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ServiceBundle:Category')->find($id);
        
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            //$entity->setSlug(\GruponivCPH\ServiceBundle\Util\Util::getSlug($entity->getTitle(), "_"));
            
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Modificada satisfactoriamente');
            
            return $this->redirect($this->generateUrl('category'));
        }

        return $this->render('ServiceBundle:Category:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Category entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('ServiceBundle:Category')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Category entity.');
            }
            
            $this->get('session')->getFlashBag()->add('notice', 'Eliminada satisfactoriamente');

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('category'));
    }
    

    /**
     * Creates a form to delete a Category entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('category_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
