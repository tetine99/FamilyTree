<?php

namespace DL\FamilytreeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class TreeController extends Controller
{

    /**
     * @Route("/tree/view")
     */
    public function defaultViewAction()
    {
        return $this->render('DLFamilytreeBundle:Tree:default.html.twig');
    }

}