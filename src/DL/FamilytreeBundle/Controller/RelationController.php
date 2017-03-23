<?php

namespace DL\FamilytreeBundle\Controller;

use DL\FamilytreeBundle\Entity\Relation;
use DL\FamilytreeBundle\Form\Type\RelationFormType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class RelationController extends Controller
{

    /**
     * @Route("/relation", name="relation")
     */
    public function indexAction(Request $request)
    {
        $message_error = "";
        $message_ok = "";
        $relation = new Relation();
        $form = $this->createForm(RelationFormType::class, $relation);
        $form->handleRequest($request);
            
        if ($form->isSubmitted() && $form->isValid())
        {

            if ($relation->getPeopleA()->getId()==$relation->getPeopleB()->getId()){
                $message_error = "Vous ne pouvez pas créer de relation sur une même personne.";
            }else if($this->checkRelationExistence($relation)){
                $message_error = "Cette relation existe déjà dans la base.";
            }else{
                $em = $this->getDoctrine()->getManager();
                $em->persist($relation);
                $em->flush();
                $message_ok = "La relation \"".$relation->getPeopleA()->getLabel();
                $message_ok .= " est ";
                $message_ok .= $relation->getRelationship()->getName();
                $message_ok .= " de ";
                $message_ok .= $relation->getPeopleB()->getLabel();
                $message_ok .= "\" a bien été créé.";
            }
        }

        return $this->render('DLFamilytreeBundle:Relation:index.html.twig', [
            'form' => $form->createView(),
            'message_error' => $message_error,
            'message_ok' => $message_ok,
            'relations' => $this->getDoctrine()
                ->getManager()
                ->getRepository('DLFamilytreeBundle:Relation')
                ->findAll(),
        ]);
    }
    
    /**
     * Vérification du fait que la relation ne soit pas
     * déjà présente dans la base
     */
    public function checkRelationExistence($relation)
    {
        $relations = $this->getDoctrine()
            ->getManager()
            ->getRepository('DLFamilytreeBundle:Relation')
            ->findAll();
        foreach( $relations as $rel ){
            if ($rel->getPeopleA()->getId()==$relation->getPeopleA()->getId()
                && $rel->getPeopleB()->getId()==$relation->getPeopleB()->getId()
                && $rel->getRelationship()->getId()==$relation->getRelationship()->getId()){
                return true;
            }
        }
        return false;
    }

    /**
     * @Route("/relation/delete/{id}", name="relation_delete")
     */
    public function deleteAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $relation = $em->getRepository('DLFamilytreeBundle:Relation')->find($id);
        if ($relation!=null) {      //Pour éviter le bug du double-clic (Merci Céline)
            $em->remove($relation);
            $em->flush();
        }

        return $this->redirectToRoute('relation');
    }

}