<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CourseForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['attr' => ['placeholder' => 'Max length 100', 'class' => 'form-control'], 'label' => 'Title'])
            ->add('subTitle', TextType::class, ['attr' => ['placeholder' => 'Max length 150', 'class' => 'form-control'], 'label' => 'Subtitle'])
            ->add('category', EntityType::class, [
                'class' => 'AppBundle:Category', 'choice_label' => 'name',
                'attr' => ['class' => 'form-control border-input'],])
            ->add('language', LanguageType::class, ['attr' => ['class' => 'form-control'], 'label' => 'Language'])
            ->add('status', ChoiceType::class, ['attr' => ['class' => 'form-control'],
                'choices' => [
                    'Draft' => 'draft',
                    'Publish' => 'publish',
                ]])
            ->add('instructionalLevel', ChoiceType::class, ['attr' => ['class' => 'form-control'],
                'choices' => [
                    'All Levels (Comprehensive)' => 'all',
                    'Introductory' => 'introductory',
                    'Intermediate' => 'intermediate',
                    'Advanced' => 'advanced',

                ]])
            ->add('summary', TextareaType::class, ['attr' => ['placeholder' => 'Enter here summary of the course.', 'class' => 'form-control', 'cols' => 40, 'rows' => 10], 'label' => 'Course Summary'])
            ->add('logo', FileType::class, ['attr' => ['class' => 'form-control'], 'label' => 'Upload course image logo', 'required' => false])
            ->add('video', TextType::class, ['attr' => ['placeholder' => 'Only embed code', 'class' => 'form-control'], 'label' => 'Put your promo video'])
            ->add('session', ChoiceType::class, ['attr' => ['class' => 'form-control'],
                'choices' => [
                    'Without enrollment sessions' => 'withoutEnrollment',
                    'With enrollment sessions' => 'withEnrollment',
                ]])
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'btn btn-lg btn-primary btn-block'),
                'label' => 'Create'))
            ->add('cancel', ButtonType::class, array(
                'attr' => array('class' => 'btn btn-lg btn-default btn-block'),
                'label' => 'Cancel'));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Course',
            'allow_extra_fields' => true,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_language';
    }
}
