<?php

namespace DL\FamilytreeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RelationController extends Controller
{

    /**
     * @Route("/relation/add", name="relation_add")
     */
    public function createAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:create.html.twig');
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