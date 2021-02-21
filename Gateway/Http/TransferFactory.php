<?php

declare(strict_types=1);

namespace CAY\Authorizenet\Gateway\Http;

use CAY\Authorizenet\Gateway\Converter\Converter;
use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;

class TransferFactory implements TransferFactoryInterface
{

    /** @var  Converter */
    private $converter;

    /** @var TransferBuilder $transferBuilder */
    private $transferBuilder;

    /**     
     *
     * @param TransferBuilder $transferBuilder
     * @param Converter $converter
     */
    public function __construct(
        TransferBuilder $transferBuilder,
        Converter $converter
    ) {
        $this->transferBuilder = $transferBuilder;
        $this->converter = $converter;
    }

    /** @inheritDoc */
    public function create(array $request)
    {
        return $this->transferBuilder
            ->setUri('https://apitest.authorize.net/xml/v1/request.api')
            ->setMethod('POST')
            ->setBody($this->converter->convert($request))
            ->setHeaders(array('Content-Type' => 'application/json'))
            ->build();
    }
}
