<?php
declare (strict_types = 1);

namespace CAY\Authorizenet\Gateway\Request\Builder;

use CAY\Authorizenet\Observer\DataAssignObserver;
use Magento\Payment\Gateway\Data\PaymentDataObject;
use Magento\Payment\Gateway\Request\BuilderInterface;
use Magento\Payment\Model\InfoInterface;
use Magento\Sales\Model\Order\Payment as OrderPayment;

class  Payment implements BuilderInterface{

   
    /** @inheritDoc */
    public function build(array $buildSubject)
    {
        /** @var PaymentDataObject $paymentDataObject */
        $paymentDataObject = $buildSubject['payment'];

        /**
         * @var InfoInterface|OrderPayment $payment
         */
        $payment = $paymentDataObject->getPayment();

        return array(
            'payment' => array(
                'creditCard' => array(
                    'cardNumber' =>  $payment->getData(DataAssignObserver::CC_NUMBER),
                    'expirationDate' => $this->getCardExpirationDate($payment),
                    'cardCode' =>  $payment->getData(DataAssignObserver::CC_CID)
                )
            )
        );

    }


    /**     
     *
     * @param InfoInterface|OrderPayment $payment
     * @return string
     */
    private function getCardExpirationDate(InfoInterface $payment){
        return sprintf(
            '%s-%s',
            $payment->getData(DataAssignObserver::CC_EXP_YEAR),
            $payment->getData(DataAssignObserver::CC_EXP_MONTH)
        );
    }
}