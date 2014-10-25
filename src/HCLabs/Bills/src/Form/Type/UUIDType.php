<?php

namespace HCLabs\Bills\Form\Type;

use HCLabs\Bills\Value\UUID;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UUIDType extends AbstractType
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
            ->add('id', 'text', $attr);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults([
                    'display_label' => 'ID',
                    'label' => false,
                    'empty_data' => function (FormInterface $form) {
                        return new UUID($form->get('id')->getData());
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
        return 'uuid_type';
    }
}