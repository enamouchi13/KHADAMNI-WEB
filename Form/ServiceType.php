<?php

namespace App\Form;
use App\Entity\User;
use App\Entity\Application;
use App\Entity\Service;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('location', ChoiceType::class, [
            'label' => 'Votre Localisation:',
            'label_attr' => [
                'style' => 'display: inline-block; width: 100%; color: #000000; font-weight: bold;',
            ],
            'row_attr' => [
                'style' => 'display: inline-block; width: 100%;',
            ],
            'choices' => [
                'Tunis' => 'Tunis',
                'Sfax' => 'Sfax',
                'Sousse' => 'Sousse',
                'Nabeul' => 'Nabeul',
                'Ariana' => 'Ariana',
                'Béja' => 'Béja',
                'Ben Arous' => 'Ben Arous',
                'Bizerte' => 'Bizerte',
                'Gabès' => 'Gabès',
                'Gafsa' => 'Gafsa',
                'Jendouba' => 'Jendouba',
                'Kairouan' => 'Kairouan',
                'Kasserine' => 'Kasserine',
                'Kébili' => 'Kébili',
                'Le Kef' => 'Le Kef',
                'Mahdia' => 'Mahdia',
                'Manouba' => 'Manouba',
                'Médenine' => 'Médenine',
                'Monastir' => 'Monastir',
                'Nabeul' => 'Nabeul',
                'Sfax' => 'Sfax',
                'Sidi Bouzid' => 'Sidi Bouzid',
                'Siliana' => 'Siliana',
                'Sousse' => 'Sousse',
                'Tataouine' => 'Tataouine',
                'Tozeur' => 'Tozeur',
                'Zaghouan' => 'Zaghouan',
            ],]
        )
            ->add('servicename',null,[
                'label' => 'Service Que Vous Desirez:',
                'label_attr' => [
                    'style' => 'display: inline-block; width: 100%; color: #000000; font-weight: bold;',
                ],
                'row_attr' => [
                    'style' => 'display: inline-block; width: 100%;',
                ],
            ])
            ->add('clientPhone',null,[
                'label' => 'Votre Numero Du Telephone:',
                'label_attr' => [
                    'style' => 'display: inline-block; width: 100%; color: #000000; font-weight: bold;',
                ],
                'row_attr' => [
                    'style' => 'display: inline-block; width: 100%;',
                ],
            ])
            ->add('idClient', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nom', 
            ])
            ->add('ouvrier',EntityType::class, [
                'class' => Application::class,
                'choice_label' => 'id', 
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Service::class,
        ]);
    }
}
