<?php

namespace DL\FamilytreeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use DL\FamilytreeBundle\Form\Type\TreeFormType;
use DL\FamilytreeBundle\Entity\Tree;
use DL\FamilytreeBundle\Entity\Permission;
use DL\FamilytreeBundle\Entity\Type;
use DL\UserBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
include 'create_tree.php';


class TreeController extends Controller
{
    /**
     * @Route("/tree/view", name="tree_view")
     * @Security("has_role('ROLE_USER')")
     */
    public function defaultViewAction(Request $request)
    {
        // récupération de l'id si disponible
        $selected_id = $request->get('id');
        $selected_people = null;
        $relations = [];
        // récupération des personnes de l'arbre sélectionné
        $peoples = $this->container->get('security.token_storage')
          ->getToken()->getUser()->getTree()->getPeoples();
        // recherche dans ces personnes de celle correspondant à l'id demandé
        foreach ($peoples as $p){
            if($p->getId() == $selected_id){
                $selected_people = $p;
            }
        }
        // recupération de l'id de l'arbre selectionné
        $tree_id = $this->getUser()->getTree()->getId();
        // si la personne selectionnée existe bien,
        // recherche des relations relatives à l'arbre sélectionné
        if ($selected_people != null){
            $relations = $this->getDoctrine()
                ->getManager()
                ->getRepository('DLFamilytreeBundle:Relation')
                ->findByTree($tree_id);
        }
        $tree = createTree( $relations, $selected_people, 3 );
        return $this->render('DLFamilytreeBundle:Tree:default.html.twig', [
            'peoples' => $peoples,
            'tree' => $tree
        ]);
    }

    /**
    * @Route("/tree", name="tree")
    * @Method({"GET", "POST"})
    * @Security("has_role('ROLE_USER')")
    */
    public function indexAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();

      $mytrees = $this->container->get('security.token_storage')
        ->getToken()->getUser()->myTrees();

        //ajout d'un arbre
        $tree = new Tree();
        $perm = false;
        $form = $this->createForm(TreeFormType::class, $tree);
        $form->handleRequest($request);

        $permissions = $this->container->get('security.token_storage')
          ->getToken()->getUser()->getPermissions();

        if($form->isSubmitted() && $form->isValid()){
          $em = $this->getDoctrine()->getManager();

          $type = $em->getRepository('DLFamilytreeBundle:Type')->findOneById(1);

          $perm = new Permission();
          $perm->setType($type);
          $perm->setUser( $this->container->get('security.token_storage')->getToken()->getUser() );
          $perm->setTree( $tree );

          $em->persist( $perm );  //constitue l'objet
  				$em->persist( $tree );  //constitue l'objet
  				$em->flush();         //enregistre en bdd

          return $this->redirectToRoute('tree');
        }
      return $this->render('DLFamilytreeBundle:Tree:index.html.twig', [
          'trees'=>$mytrees,
          'permissions'=>$permissions,
          'form'=>$form->createView()
    	]);
    }

    /**
  	 * @Route("/tree/select/{id}", name="tree_select", defaults={"id"=null})
  	 * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
  	 */
     public function selectAction(Request $request)
     {
       $id = $request->get('id');

       $em = $this->getDoctrine()->getManager();
       $tree = $em->getRepository('DLFamilytreeBundle:Tree')->findOneById($id);

       $user = $this->container->get('security.token_storage')
         ->getToken()->getUser();
        $user->setTree($tree);

        $em->persist( $user );
        $em->flush();

      return $this->redirectToRoute('tree');
     }

    /**
  	 * @Route("/tree/update/{id}", name="tree_update", defaults={"id"=null})
  	 * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_USER')")
  	 */
     public function updateAction(Request $request)
     {
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
   		  $tree = $em->getRepository('DLFamilytreeBundle:Tree')->find($id);

        //traitement formulaire
        $types = $em->getRepository('DLFamilytreeBundle:Type')->findAll();
        foreach($types as $key => $type) {
          if( $type->getId() == 1 &&  !$this->container->get('security.token_storage')
            ->getToken()->getUser()->isOwner($tree) )
            {
               array_splice($types,$key,1);
            }
        }

   		  $permissions = $em->getRepository('DLFamilytreeBundle:Permission')->findBy( array("tree" => $tree) );

        //   ->getToken()->getUser()
        // // user est propriétaire de l'arbre
        // if($this->container->get('security.token_storage')
        //   ->getToken()->getUser()->isOwner(  $tree ))
        // // si arbre est propriétaire de l'user
        // if( $tree->isOwner(  $this->container->get('security.token_storage')
        //   ->getToken()->getUser() ))

        $form = $this->createForm(TreeFormType::class, $tree);
        $form->handleRequest($request);
   			 if($form->isValid()) {
   			 $data = $form->getData();
   			 $em->flush();
         return $this->redirectToRoute('tree');
          }
       return $this->render('DLFamilytreeBundle:Tree:update.html.twig', [
  				 'form' => $form->createView(),
           'types' => $types,
           "permissions"=>$permissions,
  		 ]);
     }

   /**
    * @Route("/tree/delete/{id}", name="tree_delete", defaults={"id"=null})
    * @Security("has_role('ROLE_USER')")
    */
	 public function deleteAction(Request $request)
	 {
		 $id = $request->get('id');
		 $em = $this->getDoctrine()->getManager();
		 $tree = $em->getRepository('DLFamilytreeBundle:Tree')->find($id);

		 $em->remove($tree);
		 $em->flush();
		 return $this->redirectToRoute('tree');
	 }

}
