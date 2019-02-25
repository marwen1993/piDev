<?php
/**
 * Created by PhpStorm.
 * User: chevc
 * Date: 13/02/2018
 * Time: 12:29
 */

namespace ProduitBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="categorieproduit")
 */

class CategorieProduit
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;
    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="ProduitBundle\Entity\CategorieParent")
     * @ORM\JoinColumn(name="id_categorie",referencedColumnName="id")
     */
    private $categorieparnet;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getCategorieparnet()
    {
        return $this->categorieparnet;
    }

    /**
     * @param mixed $categorieparnet
     */
    public function setCategorieparnet($categorieparnet)
    {
        $this->categorieparnet = $categorieparnet;
    }

    public function __toString()
    {
return $this->getNom();
    }


}