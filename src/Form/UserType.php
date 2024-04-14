<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre nom',
                    ]),
                ]
            ])
            ->add('prenom',TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre prénom',
                    ]),
                ]
            ])
            ->add('birthDate',BirthdayType::class, [
                'input'  => 'datetime_immutable',
                'label'=>'Date de Naissance'
            ])
            ->add('email',EmailType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre email',
                    ]),
                ]
            ])
            ->add('adresse',TextType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre adresse',
                    ]),
                ]
            ])
            ->add('tel',TelType::class,[
                'constraints' => [
                    new NotBlank([
                        'message' => 'Entrez votre numéro mobile',
                    ]),
                ]
            ])
            ->add('submit',SubmitType::class,[
                'label'=>'Ajouter'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
