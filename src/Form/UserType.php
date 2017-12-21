<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\LocaleType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    /**]
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', TextType::class, ['label' => 'app-user-username',
            'attr'=>['readonly'=>true] ])
        ->add('firstname', TextType::class, ['label' => 'app-user-firstname' ])
        ->add('lastname', TextType::class, ['label' => 'app-user-lastname' ])
        ->add('image', FileType::class, ['label' => 'app-user-image'])
        ->add('locale', LocaleType::class, ['label' => 'app-user-locale'])
        /*
        ->add('role', ChoiceType::class, ['label'=> 'app-user-role', 'attr'=>['readonly'=>true],
        'choices'  => array(
            'ROLE_USER' => 'ROLE_USER',
            'ROLE_API_USER' => 'ROLE_API_USER',
            'ROLE_ADMIN' => 'ROLE_ADMIN',
            'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
        ),])
            */
        ->add('email', EmailType::class, ['label' => 'app-user-email' ])
        ->add('status', ChoiceType::class, ['label' => 'app-user-is-active', 'required' => false ,
            'choices' => [
                'A' => 'app-user-status-active',
                'I' => 'app-user-status-inactive',
                'L' => 'app-user-status-locked',
                'D' => 'app-user-status-deleted'
            ]
        ])
        //->add('lastIp', TextType::class, ['label' => 'app-user-last-ip', 'attr'=>['readonly'=>true] ])
        //->add('lastTime', DateTimeType::class, ['label' => 'app-user-last-time', 'attr'=>['readonly'=>true] ])
        ->add('dateCreation', DateTimeType::class, ['label' => 'app-user-date-created', 'attr'=>['readonly'=>true] ])
        ->add('userCreation', TextType::class, ['label' => 'app-user-user-created', 'attr'=>['readonly'=>true]])
        ->add('dateModified', DateTimeType::class, ['label' => 'app-user-date-modified', 'attr'=>['readonly'=>true] ])
        ->add('userModify', TextType::class, ['label' => 'app-user-user-modified', 'attr'=>['readonly'=>true] ])
        ->add($builder->create('_', FormType::class, array('inherit_data' => true))
        ->add('save', SubmitType::class, ['label' => 'app-user-btn-save'])
        ->add('cancel', ResetType::class, ['label' => 'app-user-btn-cancel' ])
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'app_user';
    }
}