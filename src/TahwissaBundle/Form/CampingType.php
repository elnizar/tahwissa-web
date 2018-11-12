<?php

namespace TahwissaBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use \Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use TahwissaBundle\Entity\Creneau;
use TahwissaBundle\Entity\Image;
use TahwissaBundle\Entity\Randonnee;

class CampingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('dateHeureDepart',DateTimeType::class,array("widget"=>"single_text","html5"=>false,
                    "attr"=>["class"=>"datetimepicker form-control"]

            ))
            ->add('description',TextareaType::class, array(
                "attr" => ["class" => "form-control","placeholder"=>"Description"]
            ))
            ->add('destination',TextType::class, array(
                "attr" => ["class" => "form-control","placeholder"=>"Destination"]
            ))
            ->add('frais',NumberType::class, array(
                "attr" => ["class" => "form-control","placeholder"=>"Frais de participation"]
            ))
            ->add('lieuRassemblement',TextType::class, array(
                "attr" => ["class" => "form-control","placeholder"=>"Description"]
            ))
            ->add('nombrePlaces',IntegerType::class, array(
                "attr" => ["class" => "form-control","placeholder"=>"Nombre de places"]
            ))
            ->add('duree',IntegerType::class, array(
                "attr" => ["class" => "form-control","placeholder"=>"Nombre de jours"]
            ))
            ->add('reglement',TextareaType::class, array(
                "attr" => ["class" => "form-control","placeholder"=>"Reglement"]
            ))
            ->add("photos",CollectionType::class,array(
                "entry_type"=>ImageType::class,
                "entry_options"=>array(
                    "required"=>"false",
                ),
                "allow_add"=>true,
                "prototype"=>true,
                "prototype_data"=>new Image(),
                "allow_delete"=>true,
                'by_reference' => false
            ))
            ->add("planning",CollectionType::class,array(
                "entry_type"=>CreneauType::class,
                "entry_options"=>array(
                    "required"=>"false",
                ),
                "allow_add"=>true,
                "prototype"=>true,
                "prototype_data"=>new Creneau(),
                "allow_delete"=>true,
                'by_reference' => false
            ))
            ->add("Ajouter",SubmitType::class,array(
                "attr" => ["class" => "btn btn-block btn-primary"],"label"=>"Valider"
            ));

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TahwissaBundle\Entity\Camping'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tahwissabundle_randonnee';
    }


}
