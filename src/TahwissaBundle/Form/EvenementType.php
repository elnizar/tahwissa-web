<?php

namespace TahwissaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EvenementType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('boosted')->add('dateHeureDepart')->add('description')->add('destination')->add('frais')->add('lieuRassemblement')->add('nombrePlaces')->add('nombreRates')->add('rating')->add('reglement')->add('statut')->add('organisateur')        ;
}
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TahwissaBundle\Entity\Evenement'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tahwissabundle_evenement';
    }


}
