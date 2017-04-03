<?php

namespace DL\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
/**
* User
*
* @ORM\Table(name="user")
* @ORM\Entity(repositoryClass="DL\UserBundle\Repository\UserRepository")
*/
class User extends BaseUser
{

  public function __construct()
  {
    parent::__construct();
    // your own logic
    $this->roles = array('ROLE_USER');
  }
  /**
  * @var int
  *
  * @ORM\Column(name="id", type="integer")
  * @ORM\Id
  * @ORM\GeneratedValue(strategy="AUTO")
  */
  protected $id;

  /**
  *
  *
  * @ORM\OneToMany(targetEntity="DL\FamilytreeBundle\Entity\Permission" , mappedBy="user" , fetch="EAGER")
  * @ORM\JoinColumn(name="id")
  *
  */
  private $permissions;


  /**
  *
  *
  * @ORM\OneToOne(targetEntity="DL\FamilytreeBundle\Entity\Tree", fetch="EAGER")
  * @ORM\JoinColumn(name="tree_id")
  *
  */
  private $tree;


  /**
  * Get id
  *
  * @return int
  */
  public function getId()
  {
    return $this->id;
  }

  /**
  * Set permissions
  *
  * @param \DL\FamilytreeBundle\Entity\Permission $permissions
  *
  * @return User
  */
  public function setPermissions(\DL\FamilytreeBundle\Entity\Permission $permissions = null)
  {
    $this->permissions = $permissions;

    return $this;
  }

  /**
  * Get permissions
  *
  * @return \DL\FamilytreeBundle\Entity\Permission
  */
  public function getPermissions()
  {
    return $this->permissions;
  }

  /**
   * Add permission
   *
   * @param \DL\FamilytreeBundle\Entity\Permission $permission
   *
   * @return User
   */
  public function addPermission(\DL\FamilytreeBundle\Entity\Permission $permission)
  {
      $this->permissions[] = $permission;

      return $this;
  }

  /**
   * Remove permission
   *
   * @param \DL\FamilytreeBundle\Entity\Permission $permission
   */
  public function removePermission(\DL\FamilytreeBundle\Entity\Permission $permission)
  {
      $this->permissions->removeElement($permission);
  }

  /**
   * Set tree
   *
   * @param \DL\FamilytreeBundle\Entity\Tree $tree
   *
   * @return User
   */
  public function setTree(\DL\FamilytreeBundle\Entity\Tree $tree = null)
  {
      $this->tree = $tree;

      return $this;
  }

  /**
   * Get tree
   *
   * @return \DL\FamilytreeBundle\Entity\Tree
   */
  public function getTree()
  {
      return $this->tree;
  }





  //vérifie les droits d'accès aux arbres
  public function hasRight($tree,$right)
  {
    $mTrees = $this->myTrees($right);
    foreach ($mTrees as $t) {
      if($tree == $t) return true;
    }
    return false;
  }

  public function isOwner($tree)
  {
    return $this->hasRight($tree, 99);
  }

  public function isAdmin($tree)
  {
    return $this->hasRight($tree, 50);
  }

  public function isVisitor($tree)
  {
    return $this->hasRight($tree, 1);
  }

  // retourne la liste des arbres dont j'ai accès
  public function myTrees($type = false)
  {
    $data = [];
    $permissions = $this->getPermissions();
    foreach($permissions as $p)
    {
      if(!$type || $p->getType()->getDroits() >= $type )
      $data[] = $p->getTree();
    }
    return $data;
  }


  //retourne la liste de mes arbres propriétaire
  public function myOwnTrees()
  {
    return $this->myTrees(99);
  }

  //permet de récupérer la liste des peoples liés à l'arbre
  public function myPeople(){
    $data = [];
    $trees = $this->myTrees();
    foreach ($trees as $key => $tree)
      {
        $peoples = $tree->getPeoples();
        foreach($peoples as $people)
        {
          $data[] = $people;
        }
      }
    return ($data);
  }

    
}
