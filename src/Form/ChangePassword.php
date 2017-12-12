<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ChangePassword extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
                'constraints' => array(
                    new NotBlank()
                ),
                'label' => 'app-login-username'
                
            ))
            ->add('email', EmailType::class, array(
                'constraints' => array(
                    new NotBlank()
                ),
                'label' => 'app-login-email'
            ))
            ->add('oldpassword', PasswordType::class, array(
                'constraints' => array(
                    new NotBlank()
                ),
                'label' => 'app-login-oldpassword'
            ))
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'app-login-password'],
                'second_options' => ['label' => 'app-login-password-confirm'],
                
            ])
            ->add('save', SubmitType::class, [
                'label' => 'app-login-btn-save', 
                'attr' => ['class' => 'button is-primary']
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
           
        ]);
    }
}