<?php

declare(strict_types=1);

namespace CAY\Authorizenet\Gateway\Request;

use CAY\Authorizenet\Gateway\Config;
use Magento\Payment\Gateway\Request\BuilderInterface;

class RequestBuilder  implements BuilderInterface
{

    /** @var BuilderInterface */
    private $builderComposite;

    /** @var Config */
    private $config;

    public function __construct(
        BuilderInterface $builder,
        Config $config
    ) {
        $this->builderComposite = $builder;
        $this->config = $config;
    }

    public function build(array $buildSubject)
    {
        return array(
            'createTransactionRequest' => array(
                'merchantAuthentication' => array(
                    'name' => $this->config->getApiLoginId(),
                    'transactionKey' => $this->config->getTransactionKey()
                ),
                'transactionRequest' => $this->builderComposite->build($buildSubject)
            )
        );
    }
}
