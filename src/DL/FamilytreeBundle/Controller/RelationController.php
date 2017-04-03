<?php

namespace DL\FamilytreeBundle\Controller;

use DL\FamilytreeBundle\Entity\Relation;
use DL\FamilytreeBundle\Form\Type\RelationFormType;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class RelationController extends Controller
{

    /**
    * @Route("/relation", name="relation")
    * @Security("has_role('ROLE_USER')")
    */
    public function indexAction(Request $request)
    {
        $relations = array();

        if($this->getUser()->getTree() != null)
        {
            // $relations = $this->getDoctrine()
            // ->getManager()
            // ->getRepository('DLFamilytreeBundle:Relation')
            // ->findByTree($this->getUser()->getTree()->getId());
            $relations = $this->container->get('security.token_storage')
              ->getToken()->getUser()->getTree()->getRelations();
        }


        $relation = new Relation();

        if( $this->getUser()->getTree() != null )    {

            $relation->setTree($this->getUser()->getTree());

        }

        $form = $this->createForm(RelationFormType::class, $relation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {

            if ($relation->getPeopleA()->getId()==$relation->getPeopleB()->getId()){

                $this->get('session')->getFlashBag()
                ->add('relationerror', 'Vous ne pouvez pas créer de relation sur une même personne.');

            }else if($this->checkRelationExistence($relation)){

                $this->get('session')->getFlashBag()
                ->add('relationerror', 'Cette relation existe déjà dans la base.');


            }else{
                $em = $this->getDoctrine()->getManager();
                $em->persist($relation);
                $em->flush();

                $this->get('session')->getFlashBag()
                ->add('relationok', "La relation " . $relation->getPeopleA()->getLabel() . " est " . $relation->getRelationship()->getName() . " de " . $relation->getPeopleB()->getLabel() . " a bien été créé.");


            }
            return $this->redirectToRoute('relation');
        }

        return $this->render('DLFamilytreeBundle:Relation:index.html.twig', [
            'form' => $form->createView(),
            'relations' => $relations,
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
        ->findByTree($this->getUser()->getTree()->getId());

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
    * @Security("has_role('ROLE_USER')")
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
