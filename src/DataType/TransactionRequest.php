<?php

namespace Gfarishyan\Arca\DataType;


class TransactionRequest extends BaseDataType {

  const AUTHORIZE_ONLY = 'authorize';
  const AUTHORIZE_CAPTURE = 'authorize_capture';

  public $order;

  public $amount;

  public $currency;

  public string $returnUrl;

  public string $language;

  public string $pageView;

  public string $formUrl;

  public string $failUrl;

  public $order_id;

  public $type;

  protected $map = [
    'order' => 'order',
    'amount' => 'amount',
    'currency' => 'currency',
    'returnUrl' => 'returnUrl',
    'language' => 'language',
    'pageView' => 'pageView',
    'formUrl' => 'formUrl',
    'order_id' => 'orderId',
    'failUrl' => 'failUrl',
  ];

  public function addOrder(Order $order) {
    $this->addDataType($order);
    return $this;
  }
}
