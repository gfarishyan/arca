<?php

namespace Gfarishyan\Arca;

use Gfarishyan\Arca\BaseApiRequest;
use Gfarishyan\Arca\DataType\TransactionRequest;
use Gfarishyan\Arca\Request\RequestInterface;
use GuzzleHttp\Client;

class OrderStatusRequest extends BaseApiRequest {
  protected $path = '/getOrderStatus.do';

  protected TransactionRequest $transactionRequest;

  public function __construct(Configuration $configuration, Client $client, TransactionRequest $transactionRequest)
  {
      parent::__construct($configuration, $client);
      $this->transactionRequest = $transactionRequest;
  }

    public function attachData(RequestInterface $request)
    {
        $request->addDataType($this->transactionRequest);
    }
}
