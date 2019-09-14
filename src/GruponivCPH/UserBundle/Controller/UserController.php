<?php

namespace GruponivCPH\UserBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Doctrine\UserManager;

use GruponivCPH\UserBundle\Entity\User;
use GruponivCPH\UserBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Response;

/**
 * User controller.
 *
 */
class UserController extends Controller
{

    /**
     * Lists all User entities.
     *
     */
    public function indexAction($role)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('UserBundle:User')->findAll();

        $aaData = array();
        foreach ($entities as $ent) {
            $delete_form = $this->createDeleteForm($ent->getId())->createView();
            $action = $this->renderView('UserBundle:User:actions.html.twig', array('delete_form' => $delete_form, 'entity_id' => $ent->getId(), 'entity_name' => $ent->getEmail()));

            $aaData[] = array(
                'action'  => $action
            );
        }

        return $this->render('UserBundle:User:index.html.twig', array(
            'entities' => $entities,
            'role' => $role,
            'aaData' => $aaData,
        ));
    }
    /**
     * Creates a new User entity.
     *
     */
    public function createAction(Request $request, $role)
    {
        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $exist_user = $em->getRepository('UserBundle:User')->findOneByEmail($entity->getEmail());

            if($exist_user) {
                $this->get('session')->getFlashBag()->add('info',
                    'Ese usuario ya se encuentra registrado.'
                );

                goto finish;
            }
            
            $entity->setRoles(array($role));
            $entity->setUsername($entity->getEmail());
            $entity->setEnabled(true);

            $em->persist($entity);
            $em->flush();

            $manipulator = $this->container->get('fos_user.util.user_manipulator');
            $manipulator->changePassword($entity->getUsername(), $entity->getPassword());

            return $this->redirect($this->generateUrl('admin_user_show', array('id' => $entity->getId())));
        }

        $this->get('session')->getFlashBag()->add('info',
            'Las contraseñas no coinciden.'
        );

        finish:

        return $this->render('UserBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'role'   => $role
        ));
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('admin_user_create', array('role' => $entity->getRoles()[0])),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Crear'));

        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction($role)
    {
        $entity = new User();
        $entity->setRoles(array($role));
        $form   = $this->createCreateForm($entity);

        $em = $this->getDoctrine()->getManager();

        return $this->render('UserBundle:User:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
            'role'   => $role,
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UserBundle:User:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('UserBundle:User:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity)
    {
        $form = $this->createFormBuilder($entity)
            ->add('password', 'repeated', array(
                'type' => 'password',
                'required' => false,
                'invalid_message' => 'Las dos contraseñas deben coincidir',
                'options' => array('label' => 'Contraseña')
            ))
            ->add('email', 'email', array(
                    'required' => true,
                )
            )
            ->add('enabled', 'checkbox', array(
                'required' => false,
            ))
        ->setAction($this->generateUrl('admin_user_update', array('id' => $entity->getId())))
        ->setMethod('PUT')
        ->getForm();

        $form->add('submit', 'submit', array('label' => 'Actualizar'));

        return $form;
    }
    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('UserBundle:User')->find($id);
        $pwd = $entity->getPassword();
        $email = $entity->getEmail();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if($entity->getEmail() != $email) {
                $exist_user = $em->getRepository('UserBundle:User')->findOneByEmail($entity->getEmail());

                if($exist_user) {
                    $this->get('session')->getFlashBag()->add('info',
                        'La cuenta de correo que quiere usar ya se encuentra en uso.'
                    );

                    goto finish;
                }
            }

            $entity->setUsername($entity->getEmail());

            if(!$entity->getPassword()) {
                $entity->setPassword($pwd);
            }

            $em->flush();

            $manipulator = $this->container->get('fos_user.util.user_manipulator');
            $manipulator->changePassword($entity->getUsername(), $entity->getPassword());

            return $this->redirect($this->generateUrl('admin_user_show', array('id' => $id)));
        }

        $this->get('session')->getFlashBag()->add('info',
            'Las contraseñas no coinciden.'
        );

        finish:

        return $this->render('UserBundle:User:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        $role = '';

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('UserBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_user', array('role' => $entity->getRoles()[0])));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Eliminar', 'attr'  => array('class'=>'btn btn-sm red')))
            ->getForm()
        ;
    }
}
