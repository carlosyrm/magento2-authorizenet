<?php

declare(strict_types=1);

namespace CAY\Authorizenet\Gateway\Http;

use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;

class TransferFactory implements TransferFactoryInterface
{

    /** @var TransferBuilder $transferBuilder */
    private $transferBuilder;

    public function __construct(TransferBuilder $transferBuilder)
    {
        $this->transferBuilder = $transferBuilder;
    }

    /** @inheritDoc */
    public function create(array $request)
    {
        return $this->transferBuilder
            ->setUri('https://apitest.authorize.net/xml/v1/request.api')
            ->setMethod('POST')
            ->setBody(json_encode($request))
            ->setHeaders(array('Content-Type' => 'application/json'))
            ->build();
    }
}
