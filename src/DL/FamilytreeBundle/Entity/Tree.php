<?php

namespace DL\FamilytreeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Tree
 *
 * @ORM\Table(name="tree")
 * @ORM\Entity(repositoryClass="DL\FamilytreeBundle\Repository\TreeRepository")
 */
class Tree
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     *
     *
     * @ORM\OneToMany(targetEntity="Permission", fetch="EAGER", cascade="remove", mappedBy="tree")
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
     * Set name
     *
     * @param string $name
     *
     * @return Tree
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set permissions
     *
     * @param \DL\FamilytreeBundle\Entity\Permission $permissions
     *
     * @return Tree
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
     * Constructor
     */
    public function __construct()
    {
        $this->permissions = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add permission
     *
     * @param \DL\FamilytreeBundle\Entity\Permission $permission
     *
     * @return Tree
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



}
