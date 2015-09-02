<?php

namespace MP\TimeSheetBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MP\TimeSheetBundle\Entity\MainContact;
use MP\TimeSheetBundle\Form\MainContactType;

/**
 * MainContact controller.
 *
 */
class MainContactController extends Controller
{

    /**
     * Lists all MainContact entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MPTimeSheetBundle:MainContact')->findAll();

        return $this->render('MPTimeSheetBundle:MainContact:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new MainContact entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new MainContact();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('maincontact_show', array('id' => $entity->getId())));
        }

        return $this->render('MPTimeSheetBundle:MainContact:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a MainContact entity.
     *
     * @param MainContact $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(MainContact $entity)
    {
        $form = $this->createForm(new MainContactType(), $entity, array(
            'action' => $this->generateUrl('maincontact_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new MainContact entity.
     *
     */
    public function newAction()
    {
        $entity = new MainContact();
        $form   = $this->createCreateForm($entity);

        return $this->render('MPTimeSheetBundle:MainContact:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a MainContact entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MPTimeSheetBundle:MainContact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MainContact entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MPTimeSheetBundle:MainContact:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing MainContact entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MPTimeSheetBundle:MainContact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MainContact entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MPTimeSheetBundle:MainContact:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a MainContact entity.
    *
    * @param MainContact $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(MainContact $entity)
    {
        $form = $this->createForm(new MainContactType(), $entity, array(
            'action' => $this->generateUrl('maincontact_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing MainContact entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MPTimeSheetBundle:MainContact')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find MainContact entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('maincontact_edit', array('id' => $id)));
        }

        return $this->render('MPTimeSheetBundle:MainContact:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a MainContact entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MPTimeSheetBundle:MainContact')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find MainContact entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('maincontact'));
    }

    /**
     * Creates a form to delete a MainContact entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('maincontact_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
