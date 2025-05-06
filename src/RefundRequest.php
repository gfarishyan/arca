<?php

namespace Gfarishyan\Arca;

use Gfarishyan\Arca\DataType\TransactionRequest;
use Gfarishyan\Arca\Request\BaseRequest;
use Gfarishyan\Arca\Request\RequestInterface;
use GuzzleHttp\Client;

class RefundRequest extends BaseApiRequest {
  protected $path = '/refund.do';
  protected TransactionRequest $orderRequest;

  public function __construct(Configuration $configuration, Client $client, TransactionRequest $request)
  {
    parent::__construct($configuration, $client);
    $this->orderRequest = $request;
  }

  protected function attachData(RequestInterface $request)
  {
    $request->addDataType($this->orderRequest);
  }
}
