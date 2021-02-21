<?php

declare(strict_types=1);

namespace CAY\Authorizenet\Gateway\Request\Builder;

use Magento\Payment\Gateway\Data\PaymentDataObjectInterface;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Sales\Api\Data\OrderItemInterface;

class ProductItems implements BuilderInterface
{

    /** @inheritDoc */
    public function build(array $buildSubject)
    {

        /** @var PaymentDataObjectInterface $paymentDataObject */
        $paymentDataObject  =  $buildSubject['payment'];
        $order = $paymentDataObject->getOrder();

        $items = array();

        /** @var OrderItemInterface $item */
        foreach ($order->getItems() as $key => $item) {
            $description = $item->getDescription() ?: $item->getName();
            $items['lineItem'][] = array(
                "itemId" =>  (string)$key,
                "name" =>  substr($item->getName(), 0, 31),
                "description" => substr($description, 0, 255),
                "quantity" =>  $item->getQtyOrdered(),
                "unitPrice" => $item->getPrice()
            );
        }

        return array(
            'lineItems' => $items
        );
    }
}
