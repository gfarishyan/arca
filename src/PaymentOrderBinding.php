<?php

namespace Gfarishyan\Arca;


use Gfarishyan\Arca\DataType\TransactionRequest;
use Gfarishyan\Arca\Request\BaseRequest;
use Gfarishyan\Arca\Request\RequestInterface;
use GuzzleHttp\Client;

class PaymentOrderBinding extends BaseApiRequest {
  protected $path = '/paymentorder.do';

  protected $orderRequest;
  public function __construct(Configuration $configuration, Client $client, TransactionRequest $order_request) {
    parent::__construct($configuration, $client);
    $this->orderRequest = $order_request;
  }

    public function setRequest(TransactionRequest $order_request) {
        $this->orderRequest = $order_request;
        return $this;
    }

    public function getRequest() :TransactionRequest {
        return $this->orderRequest;
    }

    protected function attachData(RequestInterface $request)
    {
        $request->addDataType($this->orderRequest);
    }

}
