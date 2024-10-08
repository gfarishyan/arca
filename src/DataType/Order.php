<?php

namespace Gfarishyan\Arca\DataType;

class Order extends BaseDataType {
  public $orderNumber;

  public $orderId;

  public $description;

  public $amount;

  public $params;

  protected $map = [
    'orderNumber' => 'orderNumber',
    'orderId' => 'orderId',
    'description' => 'description',
    'amount' => 'amount',
    'params' => 'params',
  ];

}
