<?php

namespace App\Form;

use App\Entity\Avis;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
#use App\Form\UtilisateurType;
use App\Entity\Utilisateur;
#use App\Entity\Utilisateur;

class AvisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('role')
            ->add('nv_satif')
            ->add('comment')
           # ->add('user') 
            #lezmou irecuperii kn l id mn l objet adheka 
           /* ->add('user', EntityType::class, [
                'choice_label' =>"id",
                //'required' => true,
                'class' =>Utilisateur::class,
                'empty_data'=>'']);*/
                ->add('user', EntityType::class, [
                    'class' => Utilisateur::class,
                    'choice_label' => 'id',
                    'choice_value' => 'id',
                ])   
             
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Avis::class,
        ]);
    }
}
