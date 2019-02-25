<?php

namespace ForumBundle\Controller;

use ForumBundle\Entity\Commentaire;
use ForumBundle\Form\CommentaireType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CommentaireController extends Controller
{
    public function AjoutAction(Request $request)
    {
        $Commantaire=new Commentaire();
        $Form=$this->createForm(CommentaireType::class,$Commantaire);
        $Form->handleRequest($request);
        if ($Form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Commantaire);
            $em->flush();
            return $this->redirectToRoute('pi_forum_affiche_Commantaire');
        }
        return $this->render('ForumBundle:Commantaire:ajouteCommantaire.html.twig'
            ,array('f'=>$Form->createView()));
    }

    public function AffichAction()
    {
        $em = $this->getDoctrine()->getManager();
        $Commantaire = $em->getRepository("ForumBundle:Commentaire")->findAll();
        return $this->render('ForumBundle:Commantaire:AfficheCommantaire.html.twig',
            array(
                'C' => $Commantaire
            ));
    }


    public function modifAction(Request $request, $id)
    {
        $r = $this->getDoctrine()->getManager();
        $Commantaire = $r->getRepository("ForumBundle:Commentaire")->find($id);
        $form = $this->createForm(CommentaireType::class, $Commantaire);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $r->persist($Commantaire);
            $r->flush();
            return $this->redirectToRoute('pi_forum_affiche_Commantaire');
        }
        return $this->render("ForumBundle:Commantaire:update.html.twig", array('form' => $form->createView()));
    }

    public function deleteAction(Request $request, $id)
    {
        $r = $this->getDoctrine()->getManager();
        $Commantaire = $r->getRepository('ForumBundle:Commentaire')->find($id);
        $r->remove($Commantaire);
        $r->flush();
        return $this->redirectToRoute('pi_forum_affiche_Commantaire');
    }
}