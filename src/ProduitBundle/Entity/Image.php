<?php
/**
 * Created by PhpStorm.
 * User: yosra
 * Date: 08/02/2017
 * Time: 01:20
 */

namespace ProduitBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @ORM\Entity
 * @ORM\Table(name="image")
 */
class Image {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**

     * @ORM\ManyToOne(targetEntity="ProduitBundle\Entity\Produit", cascade={"remove"})
     * @ORM\JoinColumn(referencedColumnName="id")
     */

    private $produit;


    /**
     * @var string
     *
     * @ORM\Column(name="chemin", type="string", length=20, nullable=false)
     */
    private $chemin;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active;


    /**
     * @Assert\File(maxSize="6000000")
     */
    private $file;


    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    function getId() {
        return $this->id;
    }

    function getChemin() {
        return $this->chemin;
    }

    function getActive() {
        return $this->active;
    }


    function setId($id) {
        $this->id = $id;
    }

    function setChemin($chemin) {
        $this->chemin = $chemin;
    }

    function setActive($active) {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * @param mixed $produit
     */
    public function setProduit($produit)
    {
        $this->produit = $produit;
    }








    public function getAbsolutePath()
    {
        return null === $this->chemin
            ? null
            : $this->getUploadRootDir().'/'.$this->chemin;
    }

    public function getWebPath()
    {
        return null === $this->chemin
            ? null
            : $this->getUploadDir().'/'.$this->chemin;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../web/bundles/upload/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn't screw up
        // when displaying uploaded doc/image in the view.
        return '' ;
    }
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            die('eroor');
            return;
        }

        // use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and then the
        // target filename to move to

        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()

        );

        // set the path property to the filename where you've saved the file
        $this->chemin = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->file = null;
    }

}
