<?php

namespace DL\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class UserController extends Controller {

    /**
     * @Route("/", name="user_index")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function indexAction()
    {
        $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('DLUserBundle:User');

        $listUser = $repository->findAll();

        return $this->render('DLUserBundle:User:index.html.twig', [
                    'listUser' => $listUser,
        ]);
    }

    /**
     * @Route("/del", name="user_del")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function delAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $repository = $this
                ->getDoctrine()
                ->getManager()
                ->getRepository('DLUserBundle:User');

        $id = $request->query->get('id');

        $user = $repository->findOneById($id);

        $form = $this->createFormBuilder()
                ->add('save', SubmitType::class, array('label' => 'Confirmer'))
                ->getForm();

        $form->handleRequest($request);

        
        if ($form->isSubmitted())
        {
            $em->remove($user);
            $em->flush();

            $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('DLUserBundle:User');

            $listUser = $repository->findAll();

            return $this->redirectToRoute('user_index', [
                        'listUser' => $listUser,
            ]);
        }



        return $this->render('DLUserBundle:User:del.html.twig', [
                    'user' => $user,
                    'form' => $form->createView(),
        ]);
    }

}
