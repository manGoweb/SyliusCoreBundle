<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\CoreBundle\Form\Type\Api\Checkout;

use Sylius\Bundle\CoreBundle\Form\EventSubscriber\AddDefaultBillingAddressOnOrderFormSubscriber;
use Sylius\Bundle\CoreBundle\Form\EventSubscriber\Api\SetCustomerFormSubscriber;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Jan Góralski <jan.goralski@lakion.com>
 */
class AddressType extends AbstractResourceType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('shippingAddress', 'sylius_address', ['shippable' => true])
            ->add('billingAddress', 'sylius_address')
            ->add('differentBillingAddress', 'checkbox', [
                'mapped' => false,
                'required' => false,
                'label' => 'sylius.form.checkout.addressing.different_billing_address',
            ])
            ->addEventSubscriber(new AddDefaultBillingAddressOnOrderFormSubscriber())
            ->addEventSubscriber(new SetCustomerFormSubscriber('customer'))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        $resolver
            ->setDefaults([
                'customer' => null,
                'cascade_validation' => true,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'sylius_api_checkout_address';
    }
}
