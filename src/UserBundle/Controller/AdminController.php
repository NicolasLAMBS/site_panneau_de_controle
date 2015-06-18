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
            ->setAction($this->generateUrl('admin_ajax'))
            ->setMethod('POST')
            ->add('url',      'url')
            ->add('save',     'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {

            $ch = curl_init('url');
            curl_exec($ch);
            $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($code == 200) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($url);
                $em->flush();

                $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');
            } else {
                $request->getSession()->getFlashBag()->add('notice', 'Votre URL n\'est pas valide');
            }

            return $this->redirect($this->generateUrl('app_page/UserBundle_admin', array('form' => $form->createView(),
            )));
        }
        return $this->render(':page/UserBundle:admin.html.twig', array('form' => $form->createView(),
        ));
    }

    /**
     * @Route("/admin/ajax", name="admin_ajax")
     * @Method({"POST"})
     */
    public function stockUrlAction(Request $request)
    {
        if($request){

            $url_data = $request->get('url');

            if ($url_data) {

                $urlObject = new Url();
                $urlObject->setUrl($url_data);

                $em = $this->getDoctrine()->getManager();
                    $em->persist($urlObject);
                    $em->flush();

                $idurl = $urlObject->getId();
                $datareponse = array('urlreponse' => $url_data, 'idreponse' =>  $idurl);

                return new JsonResponse($datareponse);
            }
            else {

                return new Response("\$url is null");
            }
        } else {

            return new Response("Ajax request is null");
        }
    }

    /**
     * @Route("/admin/ajax/delete", name="admin_ajax_delete")
     * @Method({"POST"})
     */
    public function deleteUrlAction(Request $request)
    {
        if($request){

            $id_data = $request->get('id');

            if ($id_data) {

                $urltarget = $this->getDoctrine()
                    ->getRepository('UserBundle:Url')
                    ->find($id_data);

                if ($urltarget) {

                    $em = $this->getDoctrine()->getManager();
                    $em->remove($urltarget);
                    $em->flush();
                    return new JsonResponse($urltarget);
                } else {

                    return new Response("\$urltarget is null");
                }
            }
            else {

                return new Response("\$id_data is null");
            }
        } else {

            return new Response("Ajax request is null");
        }
    }
}