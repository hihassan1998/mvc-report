<?php

namespace App\Form;

use App\Entity\Book;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Defines the form used to create or edit a Book entity.
 */
class BookTypeForm extends AbstractType
{
    /**
     * Builds the form fields for the Book entity.
     *
     * @param FormBuilderInterface $builder The form builder.
     * @param array<string, mixed> $options Options for the form.
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('isbn')
            ->add('author')
            ->add('image')
        ;
    }
    /**
     * Configures the options for this form.
     *
     * @param OptionsResolver $resolver The options resolver.
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
