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
     * @ORM\ManyToOne(targetEntity="People")
     * @ORM\JoinColumn(name="people_a_id", referencedColumnName="id")
     * 
     */
    private $peopleAId;
    
    
     /**
     * 
     * 
     * @ORM\ManyToOne(targetEntity="People")
     * @ORM\JoinColumn(name="people_b_id", referencedColumnName="id")
     * 
     */
    private $peopleBId;
    
    
    /**
     * 
     * @ORM\ManyToOne(targetEntity="Relationship")
     * @ORM\JoinColumn(name="relationship_id", referencedColumnName="id")
     * 
     */
    private $relationship;

    
    
    
    
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
     * Set peopleAId
     *
     * @param \DL\FamilytreeBundle\Entity\People $peopleAId
     *
     * @return Relation
     */
    public function setPeopleAId(\DL\FamilytreeBundle\Entity\People $peopleAId = null)
    {
        $this->peopleAId = $peopleAId;

        return $this;
    }

    /**
     * Get peopleAId
     *
     * @return \DL\FamilytreeBundle\Entity\People
     */
    public function getPeopleAId()
    {
        return $this->peopleAId;
    }

    /**
     * Set peopleBId
     *
     * @param \DL\FamilytreeBundle\Entity\People $peopleBId
     *
     * @return Relation
     */
    public function setPeopleBId(\DL\FamilytreeBundle\Entity\People $peopleBId = null)
    {
        $this->peopleBId = $peopleBId;

        return $this;
    }

    /**
     * Get peopleBId
     *
     * @return \DL\FamilytreeBundle\Entity\People
     */
    public function getPeopleBId()
    {
        return $this->peopleBId;
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
}
