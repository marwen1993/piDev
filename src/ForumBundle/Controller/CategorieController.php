<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Categorie;
use ForumBundle\Form\CategorieType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategorieController extends Controller
{

    public function AjoutAction(Request $request){
        $categorie=new Categorie();
        $Form=$this->createForm(CategorieType::class,$categorie);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            //        $categorie->setEtat("En cours");
            $em->persist($categorie);
            $em->flush();     }
        return $this->render('ForumBundle:Categorie:ajouteCategorie.html.twig'
            ,array('f'=>$Form->createView()));}



    public function AffichAction()
    {


        $em = $this->getDoctrine()->getManager();
        $categorie = $em->getRepository("ForumBundle:Categorie")->findAll();
        return $this->render('ForumBundle:Categorie:categories.html.twig',
            array(
                'C' => $categorie
            ));
    }

}
