<?php

declare(strict_types=1);

namespace CAY\Authorizenet\Gateway\Request\Builder;

use Magento\Payment\Gateway\Data\AddressAdapterInterface;
use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;

class Address implements BuilderInterface
{

    /** @inheritDoc */
    public function build(array $buildSubject)
    {
        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject  =  $buildSubject['payment'];

        $order = $paymentDataObject->getOrder();

        $billingAddress = $order->getBillingAddress();

        $shippingAddress = $order->getShippingAddress();

        $result = array(
            'billTo' => $this->getFormattedAddress($billingAddress)
        );

        if ($shippingAddress instanceof AddressAdapterInterface) {
            $result['shipTo'] = $this->getFormattedAddress($shippingAddress);
        }

        return $result;
    }

    private function getFormattedAddress(AddressAdapterInterface $address)
    {
        return array(
            "firstName" => $address->getFirstname(),
            "lastName" => $address->getLastname(),
            "company" =>  $address->getCompany() ?: '',
            "address" => $address->getStreetLine1() . $address->getStreetLine2(),
            "city" => $address->getCity(),
            "state" => $address->getRegionCode(),
            "zip" => $address->getPostcode(),
            "country" =>   $address->getCountryId()
        );
    }
}
