<?php

namespace BlindBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class TournoiType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
           $builder->add('nom',TextType::class,['attr'   =>  array(
                    'class'   => 'form-control')])
                ->add('dateDebut', DateType::class, array(
                    'widget' => 'single_text',
                    'required' => false,
                    'attr'   =>  array(
                    'class'   => 'form-control')))
                ->add('theme', EntityType::class,[
                    'class' => 'BlindBundle:Theme',
                    'choice_label' => 'libelle',
            ]);

    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'BlindBundle\Entity\Tournoi'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'blindbundle_tournoi';
    }


}
