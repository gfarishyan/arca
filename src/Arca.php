<?php

namespace Arca;

use Arca\DataType\TransactionRequest;
use Arca\Exception\ArcaException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

class Arca {

  public const PRODUCTION_MODE = 'production';
  public const TEST_MODE = 'test';

  public const BASE_URLS = [
    self::PRODUCTION_MODE => 'https://ipay.arca.am/payment/rest',
    self::TEST_MODE => 'https://ipaytest.arca.am:8445/payment/rest',
  ];

  protected GuzzleHttp\ClientInterface $httpClient;

  protected Configuration $config;

  public function __constuct(Configuration $config, ClientInterface $http_client) {
    $this->config = $config;
    $this->httpClient = $http_client;
  }

  public function getConfig()
  {
      return $this->config;
  }

  public function registerOrder(TransactionRequest $request, $transaction_mode = TransactionRequest::AUTHORIZE_CAPTURE) {
    switch ($transaction_mode) {
      case TransactionRequest::AUTHORIZE_ONLY:
        $order_request = new OrderAuhorizeRequest($this->config, $this->httpClient, $request);
      break;
      default:
        $order_request = new RegisterOrderRequest($this->config, $this->httpClient, $request);
        break;
    }

    try {
      $response = $order_request->execute();
    } catch (RequestException $e) {
      throw new ArcaException($e);
    }

    return new ArcaOrderResponse($response);
  }

}
