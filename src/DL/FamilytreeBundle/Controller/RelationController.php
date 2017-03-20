<?php

namespace DL\FamilytreeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class RelationController extends Controller
{

    /**
     * @Route("/relation/create", name="createR")
     */
    public function createAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:create.html.twig');
    }

    /**
     * @Route("/relation/delete/{id}", name="deleteR")
     */
    public function deleteAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:delete.html.twig');
    }

    /**
     * @Route("/relation/update/{id}, name="updateR")
     */
    public function updateAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:update.html.twig');
    }
    
    /**
     * @Route("/relations", name="listeR")
     */
    public function listAction()
    {
        return $this->render('DLFamilytreeBundle:Relation:list.html.twig');
    }


}