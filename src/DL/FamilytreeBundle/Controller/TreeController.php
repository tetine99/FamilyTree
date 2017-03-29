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

class TreeController extends Controller
{

    /**
     * @Route("/tree/view/{id}", name="tree_view")
     */
    public function defaultViewAction(Request $request)
    {
        $selected_people = null;
        $selected_id = $request->get('id');
        $message = "";
        $tree=[];

        $peoples = $this->getDoctrine()
            ->getManager()
            ->getRepository('DLFamilytreeBundle:People')
            ->findAll();

        foreach ($peoples as $p){
            if($p->getId()==$selected_id){
                $selected_people = $p;
            }
        }

        if ($selected_people != null){
            $relations = $this->getDoctrine()
                ->getManager()
                ->getRepository('DLFamilytreeBundle:Relation')
                ->findAll();
            $tree = $this->createTree($relations,$selected_people,3);
        }else{
            $message = "L'utilisateur demandé n'existe pas.";
        }
    }

    public function createTree($relations,$people,$deep)
    {

        $tree = array(
            "label" => $people->getLabel(),
            "relations" => array()

        );
        foreach ($relations as $rel){
            if($rel->getPeopleB()->getId()==$people->getId()){
                if ($deep > 0){
                    $tree["relations"][$rel->getRelationship()->getName()] = $this->createTree(
                        $relations,
                        $rel->getPeopleA(),
                        $deep-1
                    );
                }
            }
        }
        return $tree;
    }


    /**
    * @Route("/tree", name="tree")
    *@Method({"GET", "POST"})
    */
    public function indexAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();
  		// $trees = $em->getRepository('DLFamilytreeBundle:Tree')
  		// 	->findAll();

      $mytrees = $this->container->get('security.token_storage')
        ->getToken()->getUser()->myTrees();

        //ajout d'un arbre
        $tree = new Tree();
        $p = false;
        $form = $this->createForm(TreeFormType::class, $tree);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
          $em = $this->getDoctrine()->getManager();

          $type = $em->getRepository('DLFamilytreeBundle:Type')->findOneById(1);

          $p = new Permission();
          $p->setType($type);
          $p->setUser( $this->container->get('security.token_storage')->getToken()->getUser() );
          $p->setTree( $tree );

          $em->persist( $p );  //constitue l'objet
  				$em->persist( $tree );  //constitue l'objet
  				$em->flush();         //enregistre en bdd

          return $this->redirectToRoute('tree');
        }
      return $this->render('DLFamilytreeBundle:Tree:index.html.twig', [
          //'trees'=>$trees,
          'trees'=>$mytrees,

          'form'=>$form->createView()
    	]);
    }

    /**
  	 * @Route("/tree/update/{id}", name="tree_update", defaults={"id"=null})
  	 * @Method({"GET", "POST"})
  	 */
     public function updateAction(Request $request)
     {
        $id = $request->get('id');

        $em = $this->getDoctrine()->getManager();
   		  $tree = $em->getRepository('DLFamilytreeBundle:Tree')->find($id);



        //traitement formulaire


        $types = $em->getRepository('DLFamilytreeBundle:Type')->findAll();


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
