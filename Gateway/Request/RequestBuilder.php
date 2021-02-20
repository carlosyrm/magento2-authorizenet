<?php

declare(strict_types=1);

namespace CAY\Authorizenet\Gateway\Request;

use Magento\Payment\Gateway\Request\BuilderInterface;

class RequestBuilder  implements BuilderInterface
{

    private $builderComposite;

    public function __construct(BuilderInterface $builder)
    {
        $this->builderComposite = $builder;
    }

    public function build(array $buildSubject)
    {
        return array(
            'createTransactionRequest' => array(
                'merchantAuthentication' => array(
                    'name' => '74E3ceXcDg',
                    'transactionKey' => '8g2sj3g8Cm6ASL2J'
                ),
                'transactionRequest' => $this->builderComposite->build($buildSubject)
            )
        );
    }
}
