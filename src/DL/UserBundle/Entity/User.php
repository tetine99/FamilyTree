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





    // retourne la liste des arbres
    public function myTrees($owner = false)
    {
        $data = [];
        $permissions = $this->getPermissions();
        foreach($permissions as $p)
        {
          if(!$owner || $p->isOwnerType() )
            $data[] = $p->getTree();
        }
      return $data;
    }

    //retourne la liste de mes arbres propriétaire
    public function myOwnTrees()
    {
      return $this->myTrees(true);
    }




}
