<?php

namespace HCLabs\Bills\Form;

use HCLabs\Bills\Command\Scenario\OpenAccount\OpenAccountCommand;
use HCLabs\Bills\Value\BillingPeriod;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OpenAccountType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('service', 'entity', ['class' => 'HCLabs\Bills\Model\Service', 'mapped' => false])
                ->add('accountNumber', 'account_number', ['mapped' => false, 'display_label' => 'Account Number'])
                ->add('recurringCharge', 'money_type', ['mapped' => false, 'label' => false, 'display_label' => 'Recurring Charge'])
                ->add('dateOpened', 'datetime', ['mapped' => false])
                ->add('billingPeriod', 'choice', [
                        'choices' => [
                            'P1M' => 'Monthly',
                            'P3M' => 'Quarterly'
                        ],
                        'mapped' => false
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
                'empty_data' => function (FormInterface $form) {
                    return new OpenAccountCommand(
                        $form->get('service')->getData(),
                        $form->get('accountNumber')->getData(),
                        $form->get('recurringCharge')->getData(),
                        $form->get('dateOpened')->getData(),
                        new BillingPeriod($form->get('billingPeriod')->getData())
                    );
                }
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