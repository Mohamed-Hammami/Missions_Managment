<?php

namespace MP\TimeSheetBundle\Controller;

use MP\TimeSheetBundle\Entity\Associate;
use MP\TimeSheetBundle\Entity\AssociateRepository;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MP\TimeSheetBundle\Entity\Mission;
use MP\TimeSheetBundle\Form\MissionType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Mission controller.
 *
 */
class MissionController extends Controller
{

    /**
     * Lists all Mission entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MPTimeSheetBundle:Mission')->findAllAssociates();

        return $this->render('MPTimeSheetBundle:Mission:index.html.twig', array(
            'entities' => $entities,

        ));
    }
    /**
     * Creates a new Mission entity.
     *
     */
    public function createAction(Request $request)
    {

        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }

        $entity = new Mission();
        $form = $this->createCustomForm();


        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $this->fillEntity($form, $entity);

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mission', array('id' => $entity->getId())));
        }

        return $this->render('MPTimeSheetBundle:Mission:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Mission entity.
     *
     * @param Mission $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Mission $entity)
    {
        $form = $this->createForm(new MissionType(), $entity, array(
            'action' => $this->generateUrl('mission_create'),
            'method' => 'POST',
        ));


        return $form;
    }

    /**
     * Displays a form to create a new Mission entity.
     *
     */
    public function newAction()
    {
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }

        $entity = new Mission();
        //$form   = $this->createCreateForm($entity);

        $form = $this->createCustomForm();


        return $this->render('MPTimeSheetBundle:Mission:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Mission entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MPTimeSheetBundle:Mission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mission entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MPTimeSheetBundle:Mission:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Mission entity.
     *
     *
     */
    public function editAction($id)
    {
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MPTimeSheetBundle:Mission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mission entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MPTimeSheetBundle:Mission:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Mission entity.
    *
    * @param Mission $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Mission $entity)
    {
        $form = $this->createForm(new MissionType(), $entity, array(
            'action' => $this->generateUrl('mission_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Mission entity.
     *
     *
     */
    public function updateAction(Request $request, $id)
    {
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MPTimeSheetBundle:Mission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mission entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('mission_edit', array('id' => $id)));
        }

        return $this->render('MPTimeSheetBundle:Mission:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Mission entity.
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
            $entity = $em->getRepository('MPTimeSheetBundle:Mission')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mission entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mission'));
    }

    /**
     * Creates a form to delete a Mission entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mission_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    private function createCustomForm()
    {
        $form = $this->createFormBuilder()
            ->add('startDate', 'date', array(
                    'label' => 'Date de début:',
                    'data' => new \DateTime(),
                   /* 'constraints' => new Range(array(
                        'min' => ' - 2 days',
                        'minMessage' => 'date invalide'

                    ))*/
                ))
            ->add('hourNum', 'number', array(
                    'label' => 'Cout prévisionnel(en heures):',
                    'constraints' => new Range( array(
                            'min' => 0,
                            'minMessage' => "le nombre d'heure doit être > 0"
                        ))
                ))
            ->add('endDate', 'date', array(
                    'label' => 'Date de fin prévisionnel:',
                    'data' => new \DateTime(),
                    /*'constraints' => new Range( array(
                            'min' => ' -2 days',
                            'minMessage' => 'date invalide'

                        ))*/
                ))
            ->add('nature', 'entity', array(
                    'label' => 'Nature:',
                    'class' => 'MPTimeSheetBundle:Nature',
                ))
            ->add('clients', 'entity', array(
                    'label' => 'Client:',
                    'class' => 'MPTimeSheetBundle:Client'
                ))
            ->add('signatary', 'entity', array(
                    'label' => 'Signataire',
                    'class' => 'MPTimeSheetBundle:Associate',
                    'query_builder' => function(AssociateRepository $repo){
                        return $repo->findAllSignataries();
                    }
                ))

            ->add('manager', 'entity', array(
                    'label' => 'Manager/',
                    'class' => 'MPTimeSheetBundle:Associate',
                    'query_builder' => function(AssociateRepository $repo){
                        return $repo->findAllManagers();
                    }
                 ))
            ->add('chief', 'entity', array(
                    'label' => 'Chef de mission:',
                    'class' => 'MPTimeSheetBundle:Associate',
                    'query_builder' => function(AssociateRepository $repo){
                        return $repo->findAllChiefs();
                    }
                ))
            ->add('associates', 'entity', array(
                    'label' => 'Collaborateurs:',
                    'class' => 'MPTimeSheetBundle:Associate',
                    'query_builder' => function(AssociateRepository $repo){
                        return $repo->findNoMissionAssociates();
                    },
                    'multiple' => true,
                ))
            ->add('submit', 'submit', array(
                    'label' => 'Valider',
                ))
            ->add('reset', 'reset', array(
                    'label' => 'Annuler'
                ));

        $form->setAction($this->generateUrl('mission_create'));

        return $form->getForm();

    }

    private function fillEntity(Form $form, Mission $entity)
    {
        $array = $form->getData();

        $entity->setStartDate($array['startDate']);
        $entity->setHourNum($array['hourNum']);
        $entity->setEndDate($array['endDate']);
        $entity->setNature($array['nature']);
        $entity->setClients($array['clients']);
        $entity->addAssociate($array['signatary']);
        $entity->addAssociate($array['manager']);
        $entity->addAssociate($array['chief']);
        foreach($array['associates'] as $associate){
            $entity->addAssociate($associate);
        }

    }

    /**
     *
     *
     */
    public function terminateAction($id)
    {

        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('MPTimeSheetBundle:Mission')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mission entity.');
        }

        $entity->setStatus('Terminée');
        $entity->setRealEndDate(new \DateTime());

        $associates = $em->getRepository('MPTimeSheetBundle:Associate')->findAssociates($id);

        foreach($associates as $associate){
            $entity->removeAssociate($associate);
        }

        $em->flush();

        return $this->redirectToRoute('mission');

    }

    /**
     *
     *
     */

    public function removeAssociateAction($id, $asid)
    {
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }

        $em = $this->getDoctrine()->getManager();

        $mission = $em->getRepository('MPTimeSheetBundle:Mission')->find($id);

        if (!$mission) {
            throw $this->createNotFoundException('Unable to find Mission entity.');
        }

        $associate = $em->getRepository('MPTimeSheetBundle:Associate')->find($asid);

        if (!$associate) {
            throw $this->createNotFoundException('Unable to find Mission entity.');
        }

        $mission->removeAssociate($associate);

        $em->flush();

        return $this->redirectToRoute('mission');
    }

    public function onGoingAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MPTimeSheetBundle:Mission')->findOnGoing();

        return $this->render('MPTimeSheetBundle:Mission:onGoing.html.twig', array(
                'entities' => $entities,

            ));
    }

    public function completedAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MPTimeSheetBundle:Mission')->findCompleted();

        return $this->render('MPTimeSheetBundle:Mission:completed.html.twig', array(
                'entities' => $entities,

            ));
    }

    private function creteAddAssociateForm()
    {
        $form = $this->createFormBuilder()
            ->add('associates', 'entity', array(
                    'label' => 'Collaborateurs:',
                    'class' => 'MPTimeSheetBundle:Associate',
                    'query_builder' => function(AssociateRepository $repo){
                        return $repo->findNoMissions();
                    },
                    'multiple' => true,
                ))
            ->add('submit', 'submit', array(
                    'label' => 'Valider',
                ))
            ->add('reset', 'reset', array(
                    'label' => 'Annuler'
                ))
            ->getForm();

        return $form;
    }

    /**
     *
     *
     */

    public function addAssociateAction(Request $request, $id)
    {
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }

        $em = $this->getDoctrine()->getManager();
        $mission = $em->getRepository('MPTimeSheetBundle:Mission')->find($id);

        if (!$mission) {
            throw $this->createNotFoundException('Unable to find Mission entity.');
        }

        $form = $this->creteAddAssociateForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $array = $form->getData();

            foreach($array['associates'] as $associates)
            {
                $mission->addAssociate($associates);
            }

            $em->flush();

            return $this->redirect($this->generateUrl('mission_show', array('id' => $mission->getId())));
        }

        return $this->render('MPTimeSheetBundle:Mission:index.html.twig', array(
                'form'   => $form->createView(),
            ));


    }
}
