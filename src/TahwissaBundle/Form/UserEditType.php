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

class UserEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateNaissance', DateType::class, array(
                "attr" => ["class" => "form-control","placeholder"=>"Date de naissance"]) )
            ->add('nom', TextType::class, array(
                "attr" => ["class" => "form-control","placeholder"=>"Nom"]
            ))
            ->add('prenom', TextType::class, array(
                "attr" => ["class" => "form-control","placeholder"=>"Prénom"]
            ))


            ->add('password', PasswordType::class, array(
                "attr" => ["class" => "form-control","placeholder"=>"Mot de passe"]
            ))
            ->add("Modifier",SubmitType::class,array("attr"=>["class"=>"btn btn-primary"]))
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
