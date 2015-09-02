<?php

namespace MP\TimeSheetBundle\Controller;

use MP\TimeSheetBundle\Form\AssociateType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

class SecurityController extends Controller
{
    public function loginAction(Request $request)
    {
        $security = $this->get('security.context');

        if ($security->isGranted('IS_AUTHENTICATED_REMEMBERED')){

            // check if this is his/her first login

            return $this->redirect($this->generateUrl('first_login'));
        }

        $authentificationUtils = $this->get('security.authentication_utils');

        return $this->render('MPTimeSheetBundle:Security:login.html.twig', array(
                'last_username' => $authentificationUtils->getLastUsername(),
                'error' => $authentificationUtils->getLastAuthenticationError(),
            ));
    }

    public function firstLoginAction(Request $request)
    {
        $security = $this->get('security.context');
        $user = $security->getToken()->getUser();

        if ( $user->getFirstLogin() == true)
        {
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

            return $this->render('MPTimeSheetBundle:Security:firstLogin.html.twig', array(
                    'entity' => $user,
                    'form'   => $form->createView(),
                ));

        }

        return $this->redirect($this->generateUrl('accueil'));

    }
}
