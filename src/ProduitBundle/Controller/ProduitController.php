<?php

namespace ProduitBundle\Controller;

use ProduitBundle\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ProduitBundle\Entity\Image;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class ProduitController extends Controller
{


    public function indexfrontAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('ProduitBundle:Produit')->findBy(array("visib"=>1));
$image = $em->getRepository('ProduitBundle:Image')->findAll();
        $promotion = $em->getRepository('ProduitBundle:PromitionPrix')->findAll();
        return $this->render('ProduitBundle:produit:indexfront.html.twig', array(
            'produits' => $produits,
            'images'=>$image,
            'promos'=>$promotion
        ));
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $produits = $em->getRepository('ProduitBundle:Produit')->findAll();

        return $this->render('ProduitBundle:produit:index.html.twig', array(
            'produits' => $produits,
        ));
    }


    public function newAction(Request $request)
    {

        $user = $this->getUser();
        $produit = new Produit();
        $form = $this->createForm('ProduitBundle\Form\ProduitType', $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $produit->setUser($user);
            $produit->setVisib(1);
            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('ProduitBundle:produit:new.html.twig', array(
            'produit' => $produit,
            'form' => $form->createView(),
        ));

    }


    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('ProduitBundle:Produit')->findBy(array('id'=>$id));
        return $this->render('ProduitBundle:produit:show.html.twig', array(
            'produit' => $produit
        ));
      /*  $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($produit);
        return new JsonResponse($formatted);*/
    }

    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $produit = $em->getRepository('ProduitBundle:Produit')->find($id);
        $editForm = $this->createForm('ProduitBundle\Form\ProduitType', $produit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            $em->persist($produit);
            $em->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('ProduitBundle:produit:edit.html.twig', array(
            'produit' => $produit,
            'edit_form' => $editForm->createView()

        ));
    }


    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $produit = $em->getRepository('ProduitBundle:Produit')->find($id);
        $em->remove($produit);
        $em->flush();


        return $this->redirectToRoute('produit_index');
    }
    public function ajout_imageAction(\Symfony\Component\HttpFoundation\Request $req,$id){

        $em = $this->getDoctrine()->getManager();
        $image= new Image();

        $image->setActive(true);
        $user =$this->getUser();
        $produit = $em->getRepository('ProduitBundle:Produit')->find($id);
        $image->setProduit($produit);
        $form = $this->createForm('ProduitBundle\Form\ImageType', $image);

        $form->handleRequest($req);
        if($form->isValid()){

            $em=$this->getDoctrine()->getManager();
            $image->upload();
            //var_dump($prd);
            $em->persist($image);
            $em->flush();
            return $this->redirectToRoute('produit_index');

        }

        return $this->render('ProduitBundle:produit:image.html.twig',array('form'=>$form->createView()));

    }
    public function aff_imageAction($id){
        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('ProduitBundle:Produit')->find($id);
        $image = $em->getRepository('ProduitBundle:Image')->findBy(array("produit"=>$produit));

        return $this->render('ProduitBundle:produit:imageaff.html.twig', array(
            'image' => $image

        ));
    }
    public function visibleAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $produit = $em->getRepository('ProduitBundle:Produit')->find($id);
        $vv = $produit->getVisib();
        if($vv == 0){
            $produit->setVisib(1);
        }else{
            $produit->setVisib(0);
        }
        $em->persist($produit);
        $em->flush();
        return $this->redirectToRoute('produit_index');
    }

    public function allAction()
    {
        $tasks =$this->getDoctrine()->getManager()
            ->getRepository('ProduitBundle:Produit')
            ->findAll();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($tasks);
        return new JsonResponse($formatted);
    }

    public function new1Action($nom,$prix,$visib,$img,$id)
    {
        $em = $this->getDoctrine()->getManager();
        $task = new Produit();
        $task->setNom($nom);
        $task->setPrix($prix);
        $task->setVisib($visib);
        $task->setImage($img);
        $user=$em->getRepository('UserBundle:User')->find($id);
        $task->setUser($user);
       // $task->setUser($request->get( 'user'));



        $em->persist($task);
        $em->flush();

        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($task);
        return new JsonResponse($formatted);
    }

}
