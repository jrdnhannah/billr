<?php

namespace HCLabs\Bills\Form\Type;

use HCLabs\Bills\Value\AccountNumber;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccountNumberType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $attr = [
            'label' => $options['display_label'],
            'mapped' => false
        ];

        $builder
            ->add('accountNumber', 'text', $attr);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                    'display_label' => 'Account Number',
                    'label' => false,
                    'empty_data' => function (FormInterface $form) {
                        return new AccountNumber($form->get('accountNumber')->getData());
                    }
                ]
            );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'account_number';
    }
}