<?php

namespace DL\FamilytreeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Type
 *
 * @ORM\Table(name="type")
 * @ORM\Entity(repositoryClass="DL\FamilytreeBundle\Repository\TypeRepository")
 */
class Type
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
     * @ORM\OneToMany(targetEntity="Permission", mappedBy="type", fetch="EAGER")
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
     * @return Type
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
     * @return Type
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
     * @return Type
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
