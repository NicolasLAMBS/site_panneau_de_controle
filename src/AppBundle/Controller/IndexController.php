<?php
// src/appBundle/Controller/IndexController.php

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
     * @Route("/", name="app_page/appBundle_index")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        return $this->render(':page/appBundle:index.html.twig');
    }
}