<?php

namespace DL\FamilytreeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use DL\FamilytreeBundle\Entity\Permission;

class PermissionController extends Controller
{
  /**
  * @Route("/permission/add", name="permission_add", defaults={"id"=null})
  */
    public function addPermissionAction(Request $request)
    {
  		$em = $this->getDoctrine()->getManager();

      $email = $request->get("mail");
      $id_tree = $request->get("id_tree");
      $id_type = $request->get("type");

      $tree = $em->getRepository('DLFamilytreeBundle:Tree')->findOneById($id_tree);
      $type = $em->getRepository('DLFamilytreeBundle:Type')->findOneById($id_type);
      $user =
      $em->getRepository('DLUserBundle:User')->findOneBy( array("email" => $email) );
      if( $user && $type && $tree ){

        $p = new Permission();
        $p->setType($type);
        $p->setUser( $user );
        $p->setTree( $tree );

        $em->persist( $p );  //constitue l'objet
        $em->flush();         //enregistre en bdd
        return $this->redirectToRoute('tree');
      } else {

      }

    return $this->redirectToRoute('tree_update', array("id" => $id_tree));

    }


    /**
 		* @Route("/permission/delete/{id}", name="permission_delete", defaults={"id"=null})
 		*/
 	 public function deletePermissionAction(Request $request)
 	 {
 		 $id = $request->get('id');
 		 $em = $this->getDoctrine()->getManager();

 		 $permission = $em->getRepository('DLFamilytreeBundle:Permission')->find($id);
     $id_tree = $permission->getTree()->getId();

 		 $em->remove($permission);
 		 $em->flush();
 		 return $this->redirectToRoute('tree');
 	 }



}
