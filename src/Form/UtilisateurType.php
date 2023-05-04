<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use EWZ\Bundle\RecaptchaBundle\Form\Type\EWZRecaptchaType;


class UtilisateurType extends AbstractType
{
      public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cin')
            ->add('nom')
            ->add('prenom')
            ->add('mail')
           ->add('password', PasswordType::class)
            ->add('role')
            ->add('tel')
        ;
    } 


/* test sghayer al recaptcha
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cin')
            ->add('nom')
            ->add('prenom')
            ->add('mail', EmailType::class)
            ->add('password', PasswordType::class)
            ->add('role')
            ->add('tel')
            ->add('captcha', EWZRecaptchaType::class, [
                'label' => 'Recaptcha',
                'attr' => [
                    'options' => [
                        'theme' => 'light',
                        'type' => 'image',
                        'size' => 'normal',
                        // Ajouter votre clé de site reCAPTCHA ici
                        '01e6817d-be49-40e5-a484-47927c0f3b35' => 'votre_site_key',
                    ]
                ]
            ]);
    }*/

   

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
