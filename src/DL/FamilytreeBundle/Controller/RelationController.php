<?php

namespace DL\FamilytreeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use DL\FamilytreeBundle\Entity\Relation;

class RelationController extends Controller
{

    /**
     * @Route("/relation/create", name="relation-create")
     */
    public function createAction()
    {
        $relation = new Relation();
        return $this->render('DLFamilytreeBundle:Relation:create.html.twig', [

        ]);
    }

    /**
     * @Route("/relation/delete/{id}", name="relation-delete")
     */
    public function deleteAction($id)
    {
        return $this->render('DLFamilytreeBundle:Relation:delete.html.twig', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/relation/update/{id}", name="relation-update")
     */
    public function updateAction($id)
    {
        return $this->render('DLFamilytreeBundle:Relation:update.html.twig', [
            'id' => $id
        ]);
    }

    /**
     * @Route("/relations", name="relation-list")
     */
    public function listAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:list.html.twig');
    }


}