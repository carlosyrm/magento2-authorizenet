<?php

declare(strict_types=1);

namespace CAY\Authorizenet\Gateway\Http;

use CAY\Authorizenet\Gateway\Config;
use CAY\Authorizenet\Gateway\Converter\Converter;
use Magento\Payment\Gateway\Http\TransferBuilder;
use Magento\Payment\Gateway\Http\TransferFactoryInterface;

class TransferFactory implements TransferFactoryInterface
{

    /** @var  Converter */
    private $converter;

    /** @var TransferBuilder $transferBuilder */
    private $transferBuilder;

    /** @var Config */
    private $config;

    /**     
     *
     * @param TransferBuilder $transferBuilder
     * @param Converter $converter
     */
    public function __construct(
        TransferBuilder $transferBuilder,
        Converter $converter,
        Config $config
    ) {
        $this->transferBuilder = $transferBuilder;
        $this->converter = $converter;
        $this->config = $config;
    }

    /** @inheritDoc */
    public function create(array $request)
    {
        return $this->transferBuilder
            // ->setUri('https://apitest.authorize.net/xml/v1/request.api')
            ->setUri($this->config->getGatewayUrl())
            ->setMethod('POST')
            ->setBody($this->converter->convert($request))
            ->setHeaders($this->config->getGatewayHeaders())
            ->build();
    }
}
