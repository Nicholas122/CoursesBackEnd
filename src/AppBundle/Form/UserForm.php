<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, ['attr' => ['placeholder' => 'First Name:', 'class' => 'form-control'], 'label' => false])
            ->add('lastName', TextType::class, ['attr' => ['placeholder' => 'Last Name:', 'class' => 'form-control'], 'label' => false])
            ->add('isStudent', CheckboxType::class, ['label' => 'Student', 'required' => false])
            ->add('isTeacher', CheckboxType::class, ['label' => 'Teacher', 'required' => false])
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-lg btn-primary btn-block'),
                'label' => 'Save user',));
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
        return 'appbundle_user';
    }
}
