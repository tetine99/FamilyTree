<?php

namespace DL\FamilytreeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RelationController extends Controller
{

    /**
     * @Route("/relation/create", name="create")
     */
    public function createAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:create.html.twig');
    }

    /**
     * @Route("/relation/delete/{id}", name="delete")
     */
    public function deleteAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:delete.html.twig');
    }

    /**
     * @Route("/relation/update/{id}", name="update")
     */
    public function updateAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:update.html.twig');
    }

    /**
     * @Route("/relations", name="liste")
     */
    public function listAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:list.html.twig');
    }


}