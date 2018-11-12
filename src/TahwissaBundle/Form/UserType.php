<?php

namespace TahwissaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageFile', VichImageType::class,  [
                'required' => false, 'allow_delete' => false, // not mandatory, default is true
                'download_link' => true,
            ])
            ->add('dateNaissance', DateType::class, array(
                "attr" => ["class" => "form-control","placeholder"=>"Date de naissance"]) )
            ->add('nom', TextType::class, array(
                "attr" => ["class" => "form-control","placeholder"=>"Nom"]
            ))
            ->add('prenom', TextType::class, array(
                "attr" => ["class" => "form-control","placeholder"=>"Prénom"]
            ))
            ->add('sexe', ChoiceType::class, array(
                "attr" => ["class" => "form-control"],
                "choices" => ["Male" => "M" , "Femelle" => "F"],
                "multiple" => false
            ))
            ->add('email', EmailType::class, array(
                "attr" => ["class" => "form-control","placeholder"=>"Email"]
            ))
            ->add('password', PasswordType::class, array(
                "attr" => ["class" => "form-control","placeholder"=>"Mot de passe"]
            ))
            ->add('Valider', SubmitType::class, array(
                "attr" => ["class" => "form-control"]
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TahwissaBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tahwissabundle_user';
    }

}
