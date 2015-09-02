<?php

namespace MP\TimeSheetBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MP\TimeSheetBundle\Entity\Associate;
use MP\TimeSheetBundle\Form\AssociateType;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


/**
 * Associate controller.
 *
 */
class AssociateController extends Controller
{

    /**
     * Lists all Associate entities.
     *
     *
     */
    public function indexAction()
    {
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MPTimeSheetBundle:Associate')->findAll();
        $missions = $em->getRepository('MPTimeSheetBundle:Mission')->findAllAssociates();

        return $this->render('MPTimeSheetBundle:Associate:index.html.twig', array(
            'entities' => $entities,
            'missions' => $missions,
        ));
    }
    /**
     * Creates a new Associate entity.
     *
     */
    public function createAction(Request $request)
    {
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }

        $entity = new Associate();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity->setUsername($entity->getEmail());
            if ($entity->getPost() != ('collaborateur' or 'chef de mission'))
            {
                $entity->setRoles(array('ROLE_ADMIN'));
            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('associate_show', array('id' => $entity->getId())));
        }

        return $this->render('MPTimeSheetBundle:Associate:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Associate entity.
     *
     * @param Associate $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Associate $entity)
    {
        $form = $this->createForm(new AssociateType(), $entity, array(
            'action' => $this->generateUrl('associate_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Valider'));
        $form->add('reset', 'reset', array('label' => 'Annuler'));

        return $form;
    }

    /**
     * Displays a form to create a new Associate entity.
     *
     *
     */
    public function newAction()
    {
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }

        $entity = new Associate();
        $form   = $this->createCreateForm($entity);

        return $this->render('MPTimeSheetBundle:Associate:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Associate entity.
     *
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MPTimeSheetBundle:Associate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Associate entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MPTimeSheetBundle:Associate:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Associate entity.
     *
     */
    public function editAction($id)
    {
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MPTimeSheetBundle:Associate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Associate entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MPTimeSheetBundle:Associate:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Associate entity.
    *
    * @param Associate $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Associate $entity)
    {
        $form = $this->createForm(new AssociateType(), $entity, array(
            'action' => $this->generateUrl('associate_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'edit' => true,
        ));

        $form->add('submit', 'submit', array('label' => 'Valider'));
        $form->add('reset', 'reset', array('label' => 'Annuler'));

        return $form;
    }
    /**
     * Edits an existing Associate entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MPTimeSheetBundle:Associate')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Associate entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('associate', array('id' => $id)));
        }

        return $this->render('MPTimeSheetBundle:Associate:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Associate entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MPTimeSheetBundle:Associate')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Associate entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('associate'));
    }

    /**
     * Creates a form to delete a Associate entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('associate_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function validateAction($id)
    {
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MPTimeSheetBundle:TimeSheet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Associate entity.');
        }

        $entity->setValidated(true);
    }

    public function myAccountAction(Request $request)
    {
        $security = $this->get('security.context');
        $user = $security->getToken()->getUser();

        $form = $this->createForm(new AssociateType(), $user, array(
                'firstLogin' => true
            ));

        $form->add('submit', 'submit', array('label' => 'Valider'))
            ->add('reset', 'reset', array('label' => 'Annuler'));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user->setFirstLogin(false);
            $em->persist($user);
            $em->flush();

            return $this->redirect($this->generateUrl('accueil'));
        }

        return $this->render('MPTimeSheetBundle:Associate:myaccount.html.twig', array(
                'entity' => $user,
                'form'   => $form->createView(),
            ));

    }
}