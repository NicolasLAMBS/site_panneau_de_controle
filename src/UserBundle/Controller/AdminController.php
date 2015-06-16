<?php
// src/UserBundle/Controller/AdminController.php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\Url;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class AdminController extends Controller
{
    /**
 * @Route("/admin", name="app_page/UserBundle_admin")
 * @Method({"GET", "POST"})
 */
    public function UrlAction(Request $request)
    {

        $url = new Url();
        $form = $this->createFormBuilder($url)
            ->add('url',      'url')
            ->add('save',     'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($url);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

            return $this->redirect($this->generateUrl('app_page/UserBundle_admin', array('form' => $form->createView(),
            )));
        }
        return $this->render(':page/UserBundle:admin.html.twig', array('form' => $form->createView(),
        ));
    }
}