<?php

/**
* @Author kevin
*/

namespace DL\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UserController extends Controller {

    // regex qui certifie la validité d'une adresse email

    private $emailPattern = '/^(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){255,})(?!(?:(?:\x22?\x5C[\x00-\x7E]\x22?)|(?:\x22?[^\x5C\x22]\x22?)){65,}@)(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22))(?:\.(?:(?:[\x21\x23-\x27\x2A\x2B\x2D\x2F-\x39\x3D\x3F\x5E-\x7E]+)|(?:\x22(?:[\x01-\x08\x0B\x0C\x0E-\x1F\x21\x23-\x5B\x5D-\x7F]|(?:\x5C[\x00-\x7F]))*\x22)))*@(?:(?:(?!.*[^.]{64,})(?:(?:(?:xn--)?[a-z0-9]+(?:-[a-z0-9]+)*\.){1,126}){1,}(?:(?:[a-z][a-z0-9]*)|(?:(?:xn--)[a-z0-9]+))(?:-[a-z0-9]+)*)|(?:\[(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){7})|(?:(?!(?:.*[a-f0-9][:\]]){7,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,5})?)))|(?:(?:IPv6:(?:(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){5}:)|(?:(?!(?:.*[a-f0-9]:){5,})(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3})?::(?:[a-f0-9]{1,4}(?::[a-f0-9]{1,4}){0,3}:)?)))?(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))(?:\.(?:(?:25[0-5])|(?:2[0-4][0-9])|(?:1[0-9]{2})|(?:[1-9]?[0-9]))){3}))\]))$/iD ';

    /**
    * @Route("/", name="user_index")
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function indexAction()
    {
        // on affiche la liste des utilisateur inscrit
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
    * @Route("/update/{id}", name="user_update")
    * @Security("has_role('ROLE_ADMIN')")
    */
    public function updateAction(Request $request)
    {
        // recuperation de l'user en fonction de son id
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('DLUserBundle:User');
        $id = $request->get('id');
        $user = $repository->findOneById($id);

        // on crée un premier formulaire pour modifier le nom d'utilisateur
        $form = $this->get("form.factory")->createNamedBuilder("usernameForm")
        ->add('username', TextType::class, array('label' => "Modification nom d'utilisateur"))
        ->add('save', SubmitType::class, array('label' => "Modifier le nom d'utilisateur"))
        ->getForm();

        // un deuxieme formulaire pour modifier l'email
        $form2 = $this->get("form.factory")->createNamedBuilder("emailForm")
        ->add('e-mail', TextType::class, array('label' => 'Modification e-mail'))
        ->add('save2', SubmitType::class, array('label' => 'Confirmer'))
        ->getForm();

        // si on a cliquer sur la validation d'un des deux formulaire
        if ($request->isMethod('POST'))
        {

            // on verifie quelle formulaire a été valider
            // si il s'agit du formulaire de username
            if ($request->request->has("usernameForm"))
            {
                $form->handleRequest($request);
                // si on clique sur changer mot de passe on est redirigé sur la page de changement de mot de passe
                $username = $form["username"]->getData();

                if($form->isValid())
                {
                    $em = $this->getDoctrine()->getEntityManager();
                    $user->setUserName($username);
                    $em->persist($user);
                    $em->flush();
                }

            }
            // si il s'agit du formulaire d'adresse email
            if ($request->request->has("emailForm"))
            {

                $form2->handleRequest($request);
                $email = $form2["e-mail"]->getData();

                // on verifie que l'email saisi est valide
                if (preg_match($this->emailPattern, $email) === 1)
                {
                    // ensuite on enregistre les modifications dans la base de données
                    $em = $this->getDoctrine()->getEntityManager();

                    $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('DLUserBundle:User');

                    $user = $repository->findOneByEmail($currentUser->getEmail());
                    $user->setEmail($email);

                    $em->persist($user);
                    $em->flush();
                }

                // sinon on affiche un message d'erreur
                else
                {
                    $this->get('session')->getFlashBag()
                    ->add('notice', 'Email invalide !');
                }
            }

        }
        return $this->render('DLUserBundle:User:update.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'form2' => $form2->createView(),
        ]);
    }

    /**
    * @Route("/del/{id}", name="user_del")
    * @Security("has_role('ROLE_ADMIN')")
    * page de suppression d'un utilisateur
    */
    public function delAction(Request $request)
    {
        // on recupere l'utilisateur en fonction de son id
        $em = $this->getDoctrine()->getEntityManager();
        $repository = $this
        ->getDoctrine()
        ->getManager()
        ->getRepository('DLUserBundle:User');
        $id = $request->get('id');
        $user = $repository->findOneById($id);

        // on crée le formulaire
        $form = $this->createFormBuilder()
        ->add('save', SubmitType::class, array('label' => 'Confirmer'))
        ->getForm();

        // on ecoute le formulaire
        $form->handleRequest($request);

        // si le formulaire a été valide
        if ($form->isSubmitted())
        {
            // on supprime l'utilisateur si l'admin a valider la suppression
            $em->remove($user);
            $em->flush();

            // on recupere ensuite tout les users
            $listUser = $repository->findAll();

            // et on redirige vers l'index
            return $this->redirectToRoute('user_index', [
                'listUser' => $listUser,
            ]);
        }

        return $this->render('DLUserBundle:User:del.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
    *
    * @Route("/profil", name="user_profil")
    * @Security("has_role('ROLE_USER')")
    */
    public function profilAction(Request $request)
    {

        // on crée un premier formulaire pour acceder a la page de modif mdp
        $form = $this->get("form.factory")->createNamedBuilder("mdpForm")
        ->add('save', SubmitType::class, array('label' => 'Modifier le mot de passe'))
        ->getForm();

        // un deuxieme formulaire pour modifier l'email
        $form2 = $this->get("form.factory")->createNamedBuilder("emailForm")
        ->add('e-mail', TextType::class, array('label' => 'Modification e-mail : '))
        ->add('save2', SubmitType::class, array('label' => 'Confirmer'))
        ->getForm();

        // si on a cliquer sur la validation d'un des deux formulaire
        if ($request->isMethod('POST'))
        {

            // on verifie quelle formulaire a été valider
            // si on souhaite modifier le mot de passe
            if ($request->request->has("mdpForm"))
            {
                $form->handleRequest($request);
                // si on clique sur changer mot de passe on est redirigé sur la page de changement de mot de passe
                if ($form->isSubmitted())
                {
                    // on redirige vers la page de modification du mot de passe
                    return $this->redirectToRoute('fos_user_change_password', [
                    ]);
                }
            }
            // si l'on valide le formulaire de modification d'adresse email
            if ($request->request->has("emailForm"))
            {
                // on ecoute le formulaire
                $form2->handleRequest($request);

                // si on valide le formulaire de modification de l'adresse email
                if ($form2->isSubmitted())
                {
                    // on recupere l'adresse saisie dans le formulaire
                    $emailaddress = $form2["e-mail"]->getData();

                    // on verifie que l'adresse email saisie est valide
                    // si oui on modifie le profil
                    if (preg_match($this->emailPattern, $emailaddress) === 1)
                    {
                        $em = $this->getDoctrine()->getEntityManager();

                        $repository = $this
                        ->getDoctrine()
                        ->getManager()
                        ->getRepository('DLUserBundle:User');

                        // on recupere l'utilisateur connecté
                        $currentUser = $this->container->get('security.token_storage')->getToken()->getUser();
                        // on modifie sont adresse email
                        $user = $repository->findOneByEmail($currentUser->getEmail());
                        $user->setEmail($emailaddress);
                        // et on enregistre en base
                        $em->persist($user);
                        $em->flush();
                        // on redirige ensuite vers le profil utilisateur
                        return $this->redirectToRoute('user_profil', [

                        ]);
                    }
                    // sinon on affiche un message d'erreur
                    else
                    {
                        $this->get('session')->getFlashBag()
                        ->add('notice', 'Email invalide !');
                    }
                }
            }
        }

        return $this->render('DLUserBundle:User:profil.html.twig', [
            'form' => $form->createView(),
            'form2' => $form2->createView(),
        ]);
    }

}
