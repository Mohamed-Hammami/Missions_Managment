<?php

namespace MP\TimeSheetBundle\Controller;

use MP\TimeSheetBundle\Utils\TimeSheetDay;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use MP\TimeSheetBundle\Entity\TimeSheet;
use MP\TimeSheetBundle\Form\TimeSheetType;

/**
 * TimeSheet controller.
 *
 */
class TimeSheetController extends Controller
{

    /**
     * Lists all TimeSheet entities.
     *
     */
    public function indexAction()
    {
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MPTimeSheetBundle:TimeSheet')->findAll();

        return $this->render('MPTimeSheetBundle:TimeSheet:index.html.twig', array(
            'entities' => $entities,
        ));
    }

    /**
     * List non validated TimeSheets ordered by day
     *
     */
    public function indexNonValidatedAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MPTimeSheetBundle:TimeSheet')->findNonValidated();

        return $this->render('MPTimeSheetBundle:TimeSheet:nonValidated.html.twig', array(
                'entities' => $entities,
            ));
    }

    /**
     * List validated TimeSheets
     *
     */
    public function indexValidatedAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MPTimeSheetBundle:TimeSheet')->findValidated();

        return $this->render('MPTimeSheetBundle:TimeSheet:validated.html.twig', array(
                'entities' => $entities,
            ));
    }

    /**
     * List Non validated TimeSheets for missions by manager
     */
    public function indexManagerTimeSheets()
    {
        $security = $this->get('security.context');

        if(!$security->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }
        ;
        $user = $security->getToken()->getUser();

        if( $user->getPost('manager'))
        {
            $em = $this->getDoctrine()->getManager();
            $entities = $em->getRepository('MPTimeSheetBundle:TimeSheet')->findManagerTimeSheets($user->getId());
            return $this->render('MPTimeSheetBundle:TimeSheet:index.html.twig', array(
                    'entities' => $entities,
                ));
        }

    }

    /**
     * Listed TimeSheets for user
     *
     */
    public function indexUserAction()
    {
        $security = $this->get('security.context');
        $entity = $security->getToken()->getUser();
        $id = $entity->getId();

        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('MPTimeSheetBundle:TimeSheet')->findAssociateTimeSheet($id);

        return $this->render('MPTimeSheetBundle:TimeSheet:indexUser.html.twig', array(
                'entities' => $entities,
            ));

    }

    /**
     * List TimeSheets for user in pages
     *
     */
    public function indexPageAction($page)
    {
        $security = $this->get('security.context');
        $entity = $security->getToken()->getUser();
        $id = $entity->getId();

        $em = $this->getDoctrine()->getManager();

        if( 3-7*($page-1) > 0 )
            $sign = '+';
        else
            $sign = '';

        $currentDate = new \DateTime();
        $currentDate->setTime(0, 0);

        $startDays = (4-7*$page).' days';
        $endDays   = $sign.(3-7*($page-1)).' days';
        $startDate = date_modify(new \DateTime(), $startDays)->setTime(0, 0);
        $endDate   = date_modify(new \DateTime(), $endDays)->setTime(0, 0);

        $timeSheets = $em->getRepository('MPTimeSheetBundle:TimeSheet')->findTimeSheets($startDate, $endDate, $id);

        $week = $this->generateWeek($startDate, $endDate, $timeSheets);
        $endDate   = date_modify($endDate, '-1 day');

        return $this->render('MPTimeSheetBundle:TimeSheet:indexPage.html.twig', array(
                'today' => $currentDate,
                'week' => $week,
                'page' => $page,
            ));
    }

    /**
     * Creates a new TimeSheet entity.
     *
     */
    public function createAction(Request $request, $id)
    {
        $entity = new TimeSheet();
        $form = $this->createCreateForm($entity, array('day' => $id));
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $associate = $entity->getAssociate();

            if ($associate->getPost() == 'signataire' or $associate->getPost() == 'manager')
                $this->validateTimeSheet($entity);

            $em->persist($entity);

            $em->flush();

            return $this->redirectToRoute('timesheet_page');
        }

        return $this->render('MPTimeSheetBundle:TimeSheet:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a TimeSheet entity.
     *
     * @param TimeSheet $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(TimeSheet $entity, $id)
    {
        $security = $this->get('security.context');
        $idAssoc = $security->getToken()->getUser()->getId();

        $form = $this->createForm(new TimeSheetType(), $entity, array(
            'action' => $this->generateUrl('timesheet_create', array('day', $id)),
            'method' => 'POST',
            'associateId' => $idAssoc,
            'day' => $id,
        ));

        $form->add('submit', 'submit', array('label' => 'Créer'));
        $form->add('reset', 'reset', array('label' => 'Annuler'));

        return $form;
    }

    /**
     * Displays a form to create a new TimeSheet entity.
     */
    public function newAction($id)
    {
        $entity = new TimeSheet();
        $form   = $this->createCreateForm($entity, $id);

        return $this->render('MPTimeSheetBundle:TimeSheet:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a TimeSheet entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MPTimeSheetBundle:TimeSheet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TimeSheet entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MPTimeSheetBundle:TimeSheet:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     *
     * Displays a form to edit an existing TimeSheet entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MPTimeSheetBundle:TimeSheet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TimeSheet entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('MPTimeSheetBundle:TimeSheet:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a TimeSheet entity.
    *
    * @param TimeSheet $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(TimeSheet $entity)
    {
        $security = $this->get('security.context');
        $id = $security->getToken()->getUser()->getId();

        $form = $this->createForm(new TimeSheetType(), $entity, array(
            'action' => $this->generateUrl('timesheet_update', array('id' => $entity->getId())),
            'method' => 'PUT',
            'associateId' => $id,
        ));

        $form->add('submit', 'submit', array('label' => 'Modifier'));
        $form->add('reset', 'reset', array('label' => 'Annuler'));

        return $form;
    }
    /**
     * Edits an existing TimeSheet entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('MPTimeSheetBundle:TimeSheet')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find TimeSheet entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('timesheet_edit', array('id' => $id)));
        }

        return $this->render('MPTimeSheetBundle:TimeSheet:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a TimeSheet entity.
     *
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('MPTimeSheetBundle:TimeSheet')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find TimeSheet entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('timesheet'));
    }

    /**
     * Creates a form to delete a TimeSheet entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('timesheet_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     *
     */

    public function validateAction($id)
    {
        if(!$this->get('security.context')->isGranted('ROLE_ADMIN')){
            throw new AccessDeniedException('Accès limité aux administrateurs!');
        }

        $em = $this->getDoctrine()->getManager();
        $timeSheet = $em->getRepository('MPTimeSheetBundle:TimeSheet')->find($id);

        if (!$timeSheet) {
            throw $this->createNotFoundException('Unable to find TimeSheet entity.');
        }

        $this->validateTimeSheet($timeSheet);

        $em->flush();

        return $this->redirect($this->generateUrl('timesheet'));
    }

    private function validateTimeSheet($timeSheet)
    {
        $em = $this->getDoctrine()->getManager();

        $mission = $timeSheet->getMission();
        $associate = $timeSheet->getAssociate();
        $associateMission = $em->getRepository('MPTimeSheetBundle:AssociateMission')
            ->findByAssociateMission($associate->getId(), $mission->getId());

        if (!$associateMission){
            throw $this->createNotFoundException('Unable to find AssociateMission entity.');
        }

        $mission->setRealHourNum( ($mission->getRealHourNum() + $timeSheet->getHourNumber()));
        $timeSheet->setValidated(true);

        $associateMission->setHourNum( ($associateMission->getHourNum() + $timeSheet->getHourNumber()));
    }

    private function generateWeek($startDate, $endDate, $timeSheets)
    {
        $endDate   = date_modify($endDate, '+1 day');

        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($startDate, $interval, $endDate);

        $week = array();
        $currentDate = new \DateTime();
        $currentDate->setTime(0, 0);
        $timeStamp = $currentDate->getTimestamp();

        foreach( $period as $dt)
        {
            $tmDay = new TimeSheetDay();
            $tmDay->setDay($dt);
            foreach( $timeSheets as $tm)
            {
                if( $tm->getDay() == $tmDay->getDay())
                    $tmDay->setTimeSheet($tm);
            }

            if ( ($tmDay->getDay()->getTimestamp() >= strtotime('-2 days', $timeStamp)) and
                ($tmDay->getDay()->getTimestamp() <= $timeStamp) and
                ($tmDay->getTimeSheet() == null))
                $tmDay->setCreatable(true);

            $tmDay->setDiffId((($timeStamp)-$tmDay->getDay()->getTimestamp())/86400);

            array_push($week, $tmDay);
        }

        return $week;
    }

}
