<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use App\Utils\FormModel\ResetPasswordRequestValidate;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordRequestType extends AbstractType
{
    protected const NAME = 'passwordRequest';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('email');
        $builder->add('link');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ResetPasswordRequestValidate::class,
        ]);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
