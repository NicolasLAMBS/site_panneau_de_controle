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

            $count = 0;
            $arrayId = array();

            foreach ($dataUrl as $urlelement) {

                $ch = curl_init($urlelement->getUrl());
                curl_exec($ch);
                $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                if ($code != 200) {

                    $arrayId[$count]= $urlelement->getId();
                    $count++;
                }
            }

            $datareponse = $arrayId;
            return new JsonResponse($datareponse);

        } else {

            return new Response("Ajax request is null");
        }
    }
}