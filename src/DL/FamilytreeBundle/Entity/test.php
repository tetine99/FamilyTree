<?php

namespace DL\FamilytreeBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * test
 *
 * @ORM\Table(name="test")
 * @ORM\Entity(repositoryClass="DL\FamilytreeBundle\Repository\testRepository")
 */
class test
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
     * @ORM\Column(name="chien", type="string", length=255)
     */
    private $chien;


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
     * Set chien
     *
     * @param string $chien
     *
     * @return test
     */
    public function setChien($chien)
    {
        $this->chien = $chien;

        return $this;
    }

    /**
     * Get chien
     *
     * @return string
     */
    public function getChien()
    {
        return $this->chien;
    }
}

