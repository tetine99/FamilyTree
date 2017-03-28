<?php

namespace DL\FamilytreeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Permission
 *
 * @ORM\Table(name="permission")
 * @ORM\Entity(repositoryClass="DL\FamilytreeBundle\Repository\PermissionRepository")
 */
class Permission
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     *
     *
     * @ORM\ManyToOne(targetEntity="DL\UserBundle\Entity\User", inversedBy="permissions", fetch="EAGER")
     * @ORM\JoinColumn(name="user_id")
     *
     */
    private $user;

    /**
     *
     *
     * @ORM\ManyToOne(targetEntity="Tree", inversedBy="permissions", fetch="EAGER")
     * @ORM\JoinColumn(name="tree_id")
     *
     */
    private $tree;

    /**
     *
     *
     * @ORM\ManyToOne(targetEntity="Type", inversedBy="permissions", fetch="EAGER")
     * @ORM\JoinColumn(name="type_id")
     *
     */
    private $type;


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
     * Set tree
     *
     * @param \DL\FamilytreeBundle\Entity\Tree $tree
     *
     * @return Permission
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

    /**
     * Set type
     *
     * @param \DL\FamilytreeBundle\Entity\Type $type
     *
     * @return Permission
     */
    public function setType(\DL\FamilytreeBundle\Entity\Type $type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return \DL\FamilytreeBundle\Entity\Type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set user
     *
     * @param \DL\UserBundle\Entity\User $user
     *
     * @return Permission
     */
    public function setUser(\DL\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \DL\UserBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->tree = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add tree
     *
     * @param \DL\FamilytreeBundle\Entity\Tree $tree
     *
     * @return Permission
     */
    public function addTree(\DL\FamilytreeBundle\Entity\Tree $tree)
    {
        $this->tree[] = $tree;

        return $this;
    }

    public function isOwnerType()
    {
        return ( $this->getType()->getId() == 1);

    }

    /**
     * Remove tree
     *
     * @param \DL\FamilytreeBundle\Entity\Tree $tree
     */
    public function removeTree(\DL\FamilytreeBundle\Entity\Tree $tree)
    {
        $this->tree->removeElement($tree);
    }
}
