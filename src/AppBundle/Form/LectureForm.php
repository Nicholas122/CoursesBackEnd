<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;
use AppBundle\Entity\Section;
use Doctrine\ORM\EntityRepository;

class LectureForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('title', TextType::class, ['attr' => ['placeholder' => 'Max length 300', 'class' => 'form-control'], 'label' => 'Title'])
        ->add('description', TextType::class, ['attr' => ['placeholder' => 'Max length 500', 'class' => 'form-control'], 'label' => 'Description'])
        ->add('section', EntityType::class, ['attr' => ['placeholder' => '-- Select from list --', 'class' => 'form-control'], 'label' => 'Select section', 'class' => Section::class, 'choice_label' => 'name',
            'query_builder' => function (EntityRepository $er)  use ($options){

                $qb = $er->createQueryBuilder('section');
                return $qb
                ->where($qb->expr()->eq('section.course', $options['course']->getId()));
            }])
        ->add('content', CKEditorType::class, ['attr' => ['class' => 'form-control'], 'label' => 'Full lecture description', 'config' => ['uiColor' => '#ffffff']])
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
            'data_class' => 'AppBundle\Entity\Lecture',
            'allow_extra_fields' => true,
        ));

        $resolver->setRequired('course');

    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_lecture';
    }
}
