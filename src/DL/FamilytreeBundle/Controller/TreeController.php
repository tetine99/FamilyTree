<?php

namespace DL\FamilytreeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use DL\FamilytreeBundle\Form\Type\TreeFormType;
use DL\FamilytreeBundle\Entity\Tree;

class TreeController extends Controller
{

    /**
     * @Route("/tree/view", name="tree_view")
     */
    public function defaultViewAction()
    {
        $relations = $this->getDoctrine()
            ->getManager()
            ->getRepository('DLFamilytreeBundle:Relation')
            ->findAll();
        return $this->render('DLFamilytreeBundle:Tree:default.html.twig', [
            'tree' => $this->createTree($relations,1,2)
        ]);
    }

    public function createTree($relations,$people_id,$deep)
    {
        $tree = array(
            "label" => "",
            "relations" => array()
        );
        foreach ($relations as $rel){
            if($rel->getPeopleA()->getId()==$people_id){
                $tree["label"]= $rel->getPeopleA()->getLabel();
                if ($deep > 0){
                    $tree["relations"][$rel->getRelationship()->getName()] = $this->createTree($relations,$rel->getPeopleB()->getId(),$deep-1);
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
  		$trees = $em->getRepository('DLFamilytreeBundle:Tree')
  			->findAll();

        //ajout d'un arbre
        $tree = new Tree();
        $form = $this->createForm(TreeFormType::class, $tree);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
          $em = $this->getDoctrine()->getManager();
  				$em->persist($tree);  //constitue l'objet
  				$em->flush();         //enregistre en bdd
          return $this->redirectToRoute('tree');
        }
      return $this->render('DLFamilytreeBundle:Tree:index.html.twig', [
    		'trees'=>$trees,
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

        $form = $this->createForm(TreeFormType::class, $tree);
        $form->handleRequest($request);
   			 if($form->isValid()) {
   			 $data = $form->getData();
   			 $em->flush();
         return $this->redirectToRoute('tree');
          }
       return $this->render('DLFamilytreeBundle:Tree:update.html.twig', [
  				 'form' => $form->createView()
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
