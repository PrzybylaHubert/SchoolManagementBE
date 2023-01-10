<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Utils\FormModel\ResetPasswordExecuteValidate;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordExecuteType extends AbstractType
{
    protected const NAME = 'passwordExecute';

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('password');
        $builder->add('selector');
        $builder->add('token');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ResetPasswordExecuteValidate::class,
        ]);
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
