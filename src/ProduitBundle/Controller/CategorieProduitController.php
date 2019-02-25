<?php

namespace ProduitBundle\Controller;

use ProduitBundle\Entity\CategorieParent;
use ProduitBundle\Entity\CategorieProduit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class CategorieProduitController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorieProduits = $em->getRepository('ProduitBundle:CategorieProduit')->findAll();

        return $this->render('ProduitBundle:categorieproduit:index.html.twig', array(
            'categorieProduits' => $categorieProduits,
        ));
    }


    public function newAction(Request $request)
    {
        $categorieProduit = new Categorieproduit();
        $form = $this->createForm('ProduitBundle\Form\CategorieProduitType', $categorieProduit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorieProduit);
            $em->flush();

            return $this->redirectToRoute('categorieproduit_index');
        }

        return $this->render('ProduitBundle:categorieproduit:new.html.twig', array(
            'categorieProduit' => $categorieProduit,
            'form' => $form->createView(),
        ));
    }


    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();

        $categorieProduit = $em->getRepository('ProduitBundle:CategorieProduit')->find($id);
        return $this->render('ProduitBundle:categorieproduit:show.html.twig', array(
            'categorieProduit' => $categorieProduit,

        ));
    }


    public function editAction(Request $request,$id)
    {
        $em = $this->getDoctrine()->getManager();

        $categorieProduit = $em->getRepository('ProduitBundle:CategorieProduit')->find($id);
        $editForm = $this->createForm('ProduitBundle\Form\CategorieProduitType', $categorieProduit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em->persist($categorieProduit);
            $em->flush();

            return $this->redirectToRoute('categorieproduit_index');
        }

        return $this->render('ProduitBundle:categorieproduit:edit.html.twig', array(
            'categorieProduit' => $categorieProduit,
            'edit_form' => $editForm->createView()

        ));
    }


    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $categorieProduit = $em->getRepository('ProduitBundle:CategorieProduit')->find($id);
        $em->remove($categorieProduit);
        $em->flush();


        return $this->redirectToRoute('categorieproduit_index');
    }

/*
 *********************************************************************************************************************
 */

    public function allAction()
    {
        $tasks = $this->getDoctrine()->getManager()
         -> getRepository('ProduitBundle:CategorieProduit')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function new1Action(Request $request)
    {    $cate = new CategorieParent();
        $task = new categorieProduit();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm('ProduitBundle\Form\CategorieProduitType');
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

        $task->setNom($request->get('nom'));


        $task->setCategorieparnet($request->get('categorieparnet'));
        $em->persist($task);
        $em->flush();}
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($task);
        return new JsonResponse($formatted);
    }


    public function AjouteCategorieAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $task = new categorieProduit();
        $task->setNom($request->get('nom'));

        $em->persist($task);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($task);
        return new JsonResponse($formatted);
    }


}
