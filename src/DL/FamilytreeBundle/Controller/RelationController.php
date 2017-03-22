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
     * @Route("/relation/add", name="relation_add")
     */
    public function createAction(Request $request)
    {
        $relation = new Relation();
        $form = $this->createForm(RelationFormType::class, $relation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $relation = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($relation);
            $em->flush();
        }

        return $this->render('DLFamilytreeBundle:Relation:add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/relation/delete/{id}", name="relation_delete")
     */
    public function deleteAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:delete.html.twig');
    }

    /**
     * @Route("/relation/update/{id}", name="relation_update")
     */
    public function updateAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:update.html.twig');
    }

    /**
     * @Route("/relation", name="relation_list")
     */
    public function listAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:list.html.twig');
    }


}