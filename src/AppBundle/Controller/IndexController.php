<?php
// src/AppBundle/Controller/IndexController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Url;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/")
 */
class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     * @Method({"GET"})
     */
    public function indexAction()
    {
        return $this->render('page/index.html.twig');
    }


    /**
     * @Route("/admin/ajax/listSite", name="index_list_site")
     * @Method({"POST"})
     */
    public function showSiteAction()
    {
        $listSite = $this->getDoctrine()
            ->getRepository('AppBundle:Url')
            ->findAll();

        return $this->render('page/listSite.html.twig', array('listSite' => $listSite,
        ));
    }


    /**
     * @Route("/ajax/checkedTime", name="admin_ajax_checked")
     * @Method({"POST"})
     */
    public function checkUrlSiteAction(Request $request)
    {
        if(!$request){

            return new Response("Ajax request is null");
        }

        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Url');
        $dataUrl = $repository->findAll();

        $countbug = 0;
        $countok = 0;
        $arrayIdBug = [];
        $arrayIdOk = [];

        foreach ($dataUrl as $urlelement) {

            $urltest = $urlelement->getUrl();
            $ch = curl_init($urltest);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_exec($ch);
            $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            /*$ch = curl_init($urlelement->getUrl());
            curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);*/

            if ($retcode == 200) {

                $arrayIdOk[$countok]= $urlelement->getId();
                $countok++;

                $em = $this->getDoctrine()->getManager();
                $urlObject = $em->getRepository('AppBundle:Url')->find($urlelement->getId());
                $urlObject ->setState('1');
                $em->flush();

            } else {

                $arrayIdBug[$countbug]= $urlelement->getId();
                $countbug++;

                $em = $this->getDoctrine()->getManager();
                $urlObject = $em->getRepository('AppBundle:Url')->find($urlelement->getId());
                $urlObject ->setState('0');
                $em->flush();
            }
        }

        $datareponse = array($arrayIdBug, $arrayIdOk);
        return new JsonResponse($datareponse);
    }
}