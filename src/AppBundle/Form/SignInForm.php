<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SignInForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['attr' => ['placeholder' => 'Email/Username:', 'class' => 'form-control'], 'label' => false])
            ->add('password', PasswordType::class, ['attr' => ['placeholder' => 'Password:', 'class' => 'form-control'], 'label' => false])
            ->add('rememberMe', CheckboxType::class, ['label' => 'Remember Me:', 'required' => false])
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-lg btn-primary btn-block'),
                'label' => 'Login' ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'allow_extra_fields' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'auth';
    }
}
