<?php

namespace DL\FamilytreeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RelationController extends Controller
{

    /**
     * @Route("/relation/create")
     */
    public function createAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:createRelation.html.twig');
    }

    /**
     * @Route("/relation/delete/{id}")
     */
    public function deleteAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:deleteRelation.html.twig');
    }

    /**
     * @Route("/relation/update/{id}")
     */
    public function updateAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:updateRelation.html.twig');
    }

    /**
     * @Route("/relations")
     */
    public function listAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:listRelation.html.twig');
    }


}