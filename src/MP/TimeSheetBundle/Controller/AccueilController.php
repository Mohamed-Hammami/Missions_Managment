<?php

namespace MP\TimeSheetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AccueilController extends Controller
{

    public function indexAction()
    {
        $security = $this->get('security.context');
        $entity = $security->getToken()->getUser();

        if ($security->isGranted('ROLE_ADMIN')) {
            return $this->render('MPTimeSheetBundle::layout.html.twig', array(
                    'user' => $entity,
                ));
        } else {
            return $this->render('MPTimeSheetBundle::layoutUser.html.twig', array(
                    'user' => $entity,
                ));
        }
    }
}
