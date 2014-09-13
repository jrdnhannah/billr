<?php

namespace HCLabs\Bills\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OpenAccountType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('service', 'entity', ['class' => 'HCLabs\Bills\Model\Service'])
                ->add('accountNumber', 'text')
                ->add('recurringCharge', 'number')
                ->add('dateOpened', 'datetime')
                ->add('billingPeriod', 'choice', [
                        'choices' => [
                            'P1M' => 'Monthly',
                            'P3M' => 'Quarterly'
                        ]
                    ]
                )
                ->add('Open', 'submit');
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
                'data_class' => 'HCLabs\Bills\Command\OpenAccountCommand',
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'hclabs_bills_open_account_type';
    }

}