<?php
// src/UserBundle/Controller/AdminController.php

namespace UserBundle\Controller;

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
class AdminController extends Controller
{
    /**
    * @Route("admin", name="admin")
    * @Method({ "GET" })
    */
    public function UrlAction(Request $request)
    {
        $url = new Url();
        $form = $this->createFormBuilder($url)
            ->setAction($this->generateUrl('admin_add_url'))
            ->setMethod('POST')
            ->add('url',      'url')
            ->add('save',     'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            return $this->redirect($this->generateUrl('admin', array('form' => $form->createView(),
            )));
        }

        return $this->render('page/admin.html.twig', array('form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/ajax/add", name="admin_add_url")
     * @Method({"POST"})
     */
    public function stockUrlAction(Request $request)
    {
        if(!$request){

            return new Response("Ajax request is null");
        }

        $url_data = $request->get('url');

        if (!$url_data) {

            return new Response("\$url is null");
        }

        $ch = curl_init($url_data);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_exec($ch);
        $retcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($retcode == 200) {

            $urlObject = new Url();
            $urlObject->setUrl($url_data);

            $em = $this->getDoctrine()->getManager();
            $em->persist($urlObject);
            $em->flush();

            $idurl = $urlObject->getId();
            $datareponse = array('urlreponse' => $url_data, 'idreponse' =>  $idurl);

            return new JsonResponse($datareponse);

        } else {

            return new JsonResponse('fail');
            return new Response("\$url is not valid");
        }
    }

    /**
     * @Route("/admin/ajax/delete", name="admin_delete_url")
     * @Method({"POST"})
     */
    public function deleteUrlAction(Request $request)
    {
        if(!$request){

            return new Response("Ajax request is null");
        }

        $id_data = $request->get('id');

        if (!$id_data) {

            return new Response("\$id_data is null");
        }

        $urltarget = $this->getDoctrine()
            ->getRepository('UserBundle:Url')
            ->find($id_data);

        if (!$urltarget) {

            return new Response("\$urltarget is null");
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($urltarget);
        $em->flush();
        return new JsonResponse($urltarget);
    }
}