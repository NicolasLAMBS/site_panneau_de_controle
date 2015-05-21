<?php
// src/UserBundle/Controller/AdminController.php

namespace UserBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/")
 */
class AdminController extends Controller
{
    /**
     * @Route("/admin", name="app_page/UserBundle_admin")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        return $this->render(':page/UserBundle:admin.html.twig');
    }
}