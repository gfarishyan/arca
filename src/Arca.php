<?php

namespace Gfarishyan\Arca;

use Gfarishyan\Arca\Configuration;
use Gfarishyan\Arca\DataType\TransactionRequest;
use Gfarishyan\Arca\Exception\ArcaException;
use Gfarishyan\Arca\Response\ArcaRegisterOrderResponse;
use Gfarishyan\Arca\Response\OrderStatusResponse;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;


class Arca {

  public const PRODUCTION_MODE = 'production';
  public const TEST_MODE = 'test';

  public const BASE_URLS = [
    self::PRODUCTION_MODE => 'https://ipay.arca.am/payment/rest',
    self::TEST_MODE => 'https://ipaytest.arca.am:8445/payment/rest',
  ];

  protected ClientInterface $httpClient;

  protected Configuration $config;

  public function __construct(Configuration $config, ClientInterface $http_client) {
    $this->config = $config;
    $this->httpClient = $http_client;
  }

  public function getConfig()
  {
      return $this->config;
  }

  public function setConfig(Configuration $config)
  {
     $this->config = $config;
     return $this;
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
      throw new ArcaException($e->getMessage(), $e->getCode());
    } catch (\Exception $e ) {
        throw new ArcaException($e->getMessage(), $e->getCode());
    }
    return new ArcaRegisterOrderResponse($response->toArray());
  }

  public function getOrderStatus(TransactionRequest $transaction_request, bool $on_site=false) :OrderStatusResponse|ArcaException {
     /*if ($on_site) {*/
         $status_request = new OrderExtendedStatusRequest($this->config, $this->httpClient, $transaction_request);
    /* } else {
         $status_request = new OrderStatusRequest($this->config, $this->httpClient, $transaction_request);
     }*/

     try {
        $response = $status_request->execute();
     } catch (RequestException $e) {
         throw new ArcaException($e->getCode(), $e->getMessage());
     } catch (\Exception $e ) {
         throw new ArcaException($e->getCode(), $e->getMessage());
     }

     return new OrderStatusResponse($response->toArray());
  }

  public function capture(TransactionRequest $request) {
       if ($request->getBindingId()) {
         $order = new PaymentOrderBinding($this->config, $this->httpClient, $request);
       } else {
          $order = new Deposit($this->config, $this->httpClient, $request);
       }

        try {
           $response = $order->execute();
        } catch (RequestException $e) {
            throw new ArcaException($e->getMessage(), $e->getCode());
        } catch (\Exception $e ) {
            throw new ArcaException($e->getMessage(), $e->getCode());
        }
        return $response;
  }

}
