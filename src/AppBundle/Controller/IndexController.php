<?php
// src/AppBundle/Controller/IndexController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @Route("/")
 */
class IndexController extends Controller
{
    /**
     * @Route("/", name="app_page_index")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Page:index.html.twig');
    }
}