<?php

namespace HCLabs\Bills\Form\Type;

use HCLabs\Bills\Value\Money;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MoneyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = [
            'label' => $options['display_label'],
            'currency' => 'GBP',
            'precision' => 2,
            'mapped' => false
        ];

        $builder
            ->add('money', 'money', $attr);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                    'display_label' => 'Money',
                    'empty_data' => function (FormInterface $form) {
                        return Money::fromFloat(
                            (float) $form->get('money')->getData()
                        );
                    }
                ]
            )
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'money_type';
    }
}