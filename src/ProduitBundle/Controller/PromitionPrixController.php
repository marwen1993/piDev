<?php

namespace ProduitBundle\Controller;

use ProduitBundle\Entity\PromitionPrix;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class PromitionPrixController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $promitionPrixes = $em->getRepository('ProduitBundle:PromitionPrix')->findAll();


        return $this->render('ProduitBundle:promitionprix:index.html.twig', array(
            'promitionPrixes' => $promitionPrixes,

        ));

    }


    public function newAction(Request $request)
    {

        $user = $this->getUser();
        $promitionPrix = new Promitionprix();
        $form = $this->createForm('ProduitBundle\Form\PromitionPrixType', $promitionPrix);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
      //      $promitionPrix->setUser($user);
            $date =new \DateTime();
            $ok = false;
            $promitionPrixes = $em->getRepository('ProduitBundle:PromitionPrix')->findAll();

            foreach ($promitionPrixes as $p){
                if($p->getProduit() == $promitionPrix->getProduit()){
                    $ok =true;
                }
            }

            $okk=false;
            if($promitionPrix->getProduit()->getUser() != $user){
                $okk=true;
            }

            if
            (
                ($promitionPrix->getPourcentage() < 100)&&
                ($promitionPrix->getDateDebut()>$date)&&
                ($promitionPrix->getDateFin()>$promitionPrix->getDateDebut())&&
                ($ok ==false)&&($okk ==false)
            )

            {
    $em->persist($promitionPrix);
    $em->flush();
    return $this->redirectToRoute('promitionprix_index');
            }
else
    {
    return $this->render('ProduitBundle:promitionprix:error.html.twig');
    }


        }
        return $this->render('ProduitBundle:promitionprix:new.html.twig', array(
            'promitionPrix' => $promitionPrix,
            'form' => $form->createView(),
        ));

    }


    public function showAction(PromitionPrix $promitionPrix)
    {
        $em = $this->getDoctrine()->getManager();

        $promitionPrix = $em->getRepository('ProduitBundle:PromitionPrix')->find($id);
        return $this->render('ProduitBundle:promitionprix:show.html.twig', array(
            'promitionPrix' => $promitionPrix

        ));
    }

    public function editAction(Request $request, $promitionPrix)
    {
        $em = $this->getDoctrine()->getManager();


        $promo = $em->getRepository('ProduitBundle:PromitionPrix')->find($promitionPrix);

        $editForm = $this->createForm('ProduitBundle\Form\PromitionPrixType', $promo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('promitionprix_index');
        }

        return $this->render('ProduitBundle:promitionprix:edit.html.twig', array(
            'promitionPrix' => $promitionPrix,
            'edit_form' => $editForm->createView()
        ));
       die();
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $promitionPrix = $em->getRepository('ProduitBundle:PromitionPrix')->find($id);
        $em->remove($promitionPrix);
        $em->flush();



        return $this->redirectToRoute('promitionprix_index');
    }

    /*
     *********************************************************************************************************************
     */

    public function allAction()
    {
        $tasks =$this->getDoctrine()->getManager()
            ->getRepository('ProduitBundle:PromitionPrix')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function new1Action(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $task = new Promitionprix();
        $task->setNom($request->get('nom'));
        $task->setDateDebut($request->get('dateDebut'));
        $date = new\DateTime();
        
        $task->setDateFin($request->get('dateFin'));
        $task->setPourcentage($request->get('pourcentage'));
       // $task->setProduit($request->get('produit'));
        $em->persist($task);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($task);
        return new JsonResponse($formatted);
    }
}
