<?php
/**
 * Created by PhpStorm.
 * User: yosra
 * Date: 08/02/2017
 * Time: 01:24
 */

namespace ProduitBundle\Form;


use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImageType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            //->add('idproduit','entity',  array('class'=>'TunisiaMallBundle:Produit','property'=>'id'))
            ->add("file",FileType::class, array('label' => 'file (image file)'))
           // ->add("ajouter","submit")
        ;

    }


    public function getName()
    {
        return 'identitypicturetype';
    }
}
