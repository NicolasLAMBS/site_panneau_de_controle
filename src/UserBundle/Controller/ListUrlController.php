<?php
// src/UserBundle/Controller/ListUrlController.php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\Url;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/")
 */
class ListUrlController extends Controller
{

    public function showUrlAction()
    {
        $listUrl = $this->getDoctrine()
            ->getRepository('UserBundle:Url')
            ->findAll();

        return $this->render(':page/UserBundle:listUrl.html.twig', array('listUrl' => $listUrl,
        ));
    }
}