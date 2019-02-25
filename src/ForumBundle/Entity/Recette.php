<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Recette
 *
 * @ORM\Table(name="recette")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\RecetteRepository")
 */
class Recette
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
     * @var int
     *
     * @ORM\Column(name="duree", type="integer")
     */
    private $duree;


    /**
     * @var string
     *
     * @ORM\Column(name="besoin", type="string", length=255)
     */
    private $besoin;



    /**
     * @var string
     *
     * @ORM\Column(name="preparation", type="string", length=4500)
     */
    private $preparation;

    /**
     * @var string
     *
     * @ORM\Column(name="BN", type="string", length=255)
     */
    private $BN;




    /**
     * @var int
     *
     * @ORM\Column(name="like", type="integer", nullable=true, options={"default":true})
     */
//    private $like;

    /**
     * @var int
     *
     * @ORM\Column(name="dislike", type="integer" , nullable=true, options={"default":true})
     */
 //   private $dislike;






    /**
     * @return mixed
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * @param mixed $categorie
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
    }

    /**
     * @var
     *
     * @ORM\ManyToOne(targetEntity="ForumBundle\Entity\Categorie")
     * @ORM\JoinColumn(name="id_categorie",referencedColumnName="id")
     */
    private $categorie;


    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * @return int
     */
    public function getDuree()
    {
        return $this->duree;
    }

    /**
     * @param int $duree
     */
    public function setDuree($duree)
    {
        $this->duree = $duree;
    }

    /**
     * @return string
     */
    public function getBesoin()
    {
        return $this->besoin;
    }

    /**
     * @param string $besoin
     */
    public function setBesoin($besoin)
    {
        $this->besoin = $besoin;
    }

    /**
     * @return string
     */
    public function getPreparation()
    {
        return $this->preparation;
    }

    /**
     * @param string $preparation
     */
    public function setPreparation($preparation)
    {
        $this->preparation = $preparation;
    }

    /**
     * @return string
     */
    public function getBN()
    {
        return $this->BN;
    }

    /**
     * @param string $BN
     */
    public function setBN($BN)
    {
        $this->BN = $BN;
    }

    /**
     * @return int
     */
 //   public function getLike()
   // {
    //    return $this->like;
  //  }

    /**
     * @param int $like
     */
  //  public function setLike($like)
   // {
   //     $this->like = $like;
  //  }

    /**
     * @return int
     */
  //  public function getDislike()
  //  {
  //      return $this->dislike;
  //  }

    /**
     * @param int $dislike
     */
 //   public function setDislike($dislike)
 //   {
 //       $this->dislike = $dislike;
 //   }



}

