<?php

namespace App\Form;
use App\Entity\User;
use App\Entity\Application;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;
class ApplicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('num',null,[
                'label' => 'Votre Numéro de Téléphone:',
                'label_attr' => [
                    'style' => 'display: inline-block; width: 100%; color: #000000; font-weight: bold;',
                ],
                'row_attr' => [
                    'style' => 'display: inline-block; width: 100%;',
                ],
            ])
            ->add('role',null,[
                'label' => 'Le Role Que Vous Souhaitez A Appliquer:',
                'label_attr' => [
                    'style' => 'display: inline-block; width: 100%; color: #000000; font-weight: bold;',
                ],
                'row_attr' => [
                    'style' => 'display: inline-block; width: 100%;',
                ],
            ])
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
                ],
            ])
            ->add('document',FileType::class,[
                'label' => 'Inserer Ici Une Piece Qui Indique Votre Expertise:',
                'label_attr' => [
                    'style' => 'display: inline-block; width: 100%; color: #000000; font-weight: bold;',
                ],
                'row_attr' => [
                    'style' => 'display: inline-block; width: 100%; ',
                ],
            ])
            ->add('idUser', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id', 
            ])
            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'constraints' => [
                    new ValidCaptcha([
                        'message' => 'Invalid captcha, please try again',
                    ]),
                ],
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Application::class,
        ]);
    }
}
