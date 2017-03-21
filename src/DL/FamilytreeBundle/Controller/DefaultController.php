<?php

namespace DL\FamilytreeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;



class DefaultController extends Controller {

    /**
     * @Route("/")
     * 
     */
    public function indexAction()
    {
        
        return $this->render('DLFamilytreeBundle:Default:index.html.twig');
    }

}
