<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // for required fields - it does not validate that they are required on server side,
            // need to manually validate.
            // https://symfony.com/doc/current/forms.html
            ->add('fullName', TextType::class, ['label' => 'Full name'])
            ->add('phoneNumber', TextType::class, ['label' => 'Phone number', 'required' => false])
            ->add('email', TextType::class, ['label' => 'Email address', 'required' => false])
            ->add('dateOfBirth', TextType::class, ['label' => 'Date of birth'])
            ->add('fileName', FileType::class, ['label' => 'File'])
            ->add('save', SubmitType::class, ['label' => 'Submit'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Person::class,
        ));
    }
}