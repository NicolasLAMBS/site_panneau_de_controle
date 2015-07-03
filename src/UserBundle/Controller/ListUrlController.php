<?php
// src/UserBundle/Controller/ListUrlController.php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\Url;
use Symfony\Component\HttpFoundation\Request;

class ListUrlController extends Controller
{
    /**
     * @Route("/admin/ajax/listUrl", name="admin_list_url")
     * @Method({"POST"})
     */
    public function showUrlAction()
    {
        $listUrl = $this->getDoctrine()
            ->getRepository('UserBundle:Url')
            ->findAll();

        return $this->render('page/index.html.twig', array('listUrl' => $listUrl,
        ));
    }
}