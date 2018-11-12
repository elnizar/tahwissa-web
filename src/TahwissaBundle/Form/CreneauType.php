<?php

namespace TahwissaBundle\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreneauType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('debut',DateTimeType::class,array("widget"=>"single_text","html5"=>false,
            "attr"=>["class"=>"datetimepicker datetimepickerdebut form-control"]
            ))
            ->add('fin',DateTimeType::class,array("widget"=>"single_text","html5"=>false,
            "attr"=>["class"=>"datetimepicker datetimepickerfin form-control"]))
            ->add('description',\Symfony\Component\Form\Extension\Core\Type\TextType::class,array(
            "attr" => ["class" => "form-control","placeholder"=>"Description"]
            ))        ;

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TahwissaBundle\Entity\Creneau'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tahwissabundle_creneau';
    }


}
