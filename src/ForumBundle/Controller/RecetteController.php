<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Recette;
use ForumBundle\Form\RecetteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RecetteController extends Controller
{

    public function AjoutAction(Request $request)
    {
        $Recette=new Recette();
        $Form=$this->createForm(RecetteType::class,$Recette);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $em = $this->getDoctrine()->getManager();
        //    $Recette->setLike(0);
        //    $Recette->setDislike(0);
            $em->persist($Recette);
            $em->flush();
            return $this->redirectToRoute('pi_forum_affiche_recette');
        }

        return $this->render('ForumBundle:Recette:ajouteRecette.html.twig'
            ,array('f'=>$Form->createView()));
    }

    public function AffichAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Recette = $em->getRepository("ForumBundle:Recette")->findAll();
        return $this->render('ForumBundle:Recette:optionRecette.html.twig',
            array( 'R' => $Recette ));
    }

    public function modifAction(Request $request, $id)
    {
        $r = $this->getDoctrine()->getManager();
        $Recette = $r->getRepository("ForumBundle:Recette")->find($id);
        $form = $this->createForm(RecetteType::class, $Recette);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $r->persist($Recette);
            $r->flush();
            return $this->redirectToRoute('pi_forum_affiche_recette');
        }
        return $this->render("ForumBundle:Recette:update.html.twig", array('form' => $form->createView()));
    }

    public function deleteAction(Request $request, $id)
    {
        $r = $this->getDoctrine()->getManager();
        $Recette = $r->getRepository('ForumBundle:Recette')->find($id);
        $r->remove($Recette);
        $r->flush();
        return $this->redirectToRoute('pi_forum_affiche_recette');
    }


    public function AffichesimpleAction()
    {
        $r = $this->getDoctrine()->getManager();
        $Recette = $r->getRepository("ForumBundle:Recette")->findAll();
        return $this->render('ForumBundle:Recette:Affichesimple.html.twig',
            array(
                'R' => $Recette
            ));
    }
}