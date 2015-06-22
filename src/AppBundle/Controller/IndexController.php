<?php
// src/appBundle/Controller/IndexController.php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use UserBundle\Entity\Url;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

    public function showSiteAction()
    {
        $listUrl = $this->getDoctrine()
            ->getRepository('UserBundle:Url')
            ->findAll();

        return $this->render(':page/appBundle:listSite.html.twig', array('listUrl' => $listUrl,
        ));
    }


    /**
     * @Route("/ajax/checkedTime", name="admin_ajax_checked")
     * @Method({"POST"})
     */
    public function checkUrlSiteAction(Request $request)
    {
        if($request){

            $repository = $this->getDoctrine()
                ->getRepository('UserBundle:Url');
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
                    $urlObject = $em->getRepository('UserBundle:Url')->find($urlelement->getId());
                    $urlObject ->setState('1');
                    $em->flush();

                } else {

                    $arrayIdBug[$countbug]= $urlelement->getId();
                    $countbug++;

                    $em = $this->getDoctrine()->getManager();
                    $urlObject = $em->getRepository('UserBundle:Url')->find($urlelement->getId());
                    $urlObject ->setState('0');
                    $em->flush();
                }
            }

            $datareponse = array($arrayIdBug, $arrayIdOk);
            return new JsonResponse($datareponse);

        } else {

            return new Response("Ajax request is null");
        }
    }
}