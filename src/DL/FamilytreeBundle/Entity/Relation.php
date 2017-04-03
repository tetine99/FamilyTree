<?php

namespace DL\FamilytreeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Relation
 *
 * @ORM\Table(name="relation")
 * @ORM\Entity(repositoryClass="DL\FamilytreeBundle\Repository\RelationRepository")
 */
class Relation {

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
     * @ORM\ManyToOne(targetEntity="People", fetch="EAGER")
     * @ORM\JoinColumn(name="people_a_id", referencedColumnName="id")
     *
     */
    private $peopleA;


    /**
     *
     *
     * @ORM\ManyToOne(targetEntity="People", fetch="EAGER")
     * @ORM\JoinColumn(name="people_b_id", referencedColumnName="id")
     *
     */
    private $peopleB;


    /**
     *
     * @ORM\ManyToOne(targetEntity="Relationship", fetch="EAGER")
     * @ORM\JoinColumn(name="relationship_id", referencedColumnName="id")
     *
     */
    private $relationship;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Tree", fetch="EAGER")
     * @ORM\JoinColumn(name="tree_id", referencedColumnName="id")
     *
     */
    private $tree;





    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set peopleA
     *
     * @param \DL\FamilytreeBundle\Entity\People $peopleA
     *
     * @return Relation
     */
    public function setPeopleA(\DL\FamilytreeBundle\Entity\People $peopleA = null)
    {
        $this->peopleA = $peopleA;

        return $this;
    }

    /**
     * Get peopleA
     *
     * @return \DL\FamilytreeBundle\Entity\People
     */
    public function getPeopleA()
    {
        return $this->peopleA;
    }

    /**
     * Set peopleB
     *
     * @param \DL\FamilytreeBundle\Entity\People $peopleB
     *
     * @return Relation
     */
    public function setPeopleB(\DL\FamilytreeBundle\Entity\People $peopleB = null)
    {
        $this->peopleB = $peopleB;

        return $this;
    }

    /**
     * Get peopleB
     *
     * @return \DL\FamilytreeBundle\Entity\People
     */
    public function getPeopleB()
    {
        return $this->peopleB;
    }

    /**
     * Set relationship
     *
     * @param \DL\FamilytreeBundle\Entity\Relationship $relationship
     *
     * @return Relation
     */
    public function setRelationship(\DL\FamilytreeBundle\Entity\Relationship $relationship = null)
    {
        $this->relationship = $relationship;

        return $this;
    }

    /**
     * Get relationship
     *
     * @return \DL\FamilytreeBundle\Entity\Relationship
     */
    public function getRelationship()
    {
        return $this->relationship;
    }

    /**
     * Set tree
     *
     * @param \DL\FamilytreeBundle\Entity\Tree $tree
     *
     * @return Relation
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


    public function getPeoples()
    {
      $data = [];
      $data[] = $this->getPeopleA();
      $data[] = $this->getPeopleB();

    return $data;
    }


}
