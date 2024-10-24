<?php

namespace Gfarishyan\Arca;

use Gfarishyan\Arca\DataType\TransactionRequest;
use Gfarishyan\Arca\Request\RequestInterface;
use GuzzleHttp\Client;

class OrderExtendedStatusRequest extends OrderStatusRequest
{
  protected $path = '/getOrderStatusExtended.do';
}
