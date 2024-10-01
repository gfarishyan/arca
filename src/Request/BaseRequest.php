<?php

namespace Arca\Request;

use Arca\Configuration;
use Arca\DataType\DataTypeInterface;
use Arca\Exception\ArcaException;
use Arca\Response\JsonResponse;
use GuzzleHttp\Exception\RequestException;

abstract class BaseRequest implements RequestInterface {

  const SANDBOX = 'https://ipaytest.arca.am:8445/payment/rest';
  const LIVE =  'https://ipay.arca.am/payment/rest';

  protected Configuration $configuration;

  protected $client;

  protected $type;

  protected $data = [];

  protected $path = '';

  public function __construct(Configuration $configuration, $client, $path,  array $data = []) {
    $this->configuration = $configuration;
    $this->client = $client;
    //$this->type = $type;
    $this->data = $data;
    $this->path = $path;
  }

  public function getBody()
  {

  }

  public function getContentType()
  {
    // TODO: Implement getContentType() method.
  }

  public function addData($name, $value) {
    $this->data[$name] = $value;
  }

  public function addDataType(DataTypeInterface $data)
  {
    $this->data[$data->getType()] = $data->toArray();
  }

  public function sendRequest() {
    $postUrl = ($this->configuration->isSandbox()) ? self::SANDBOX : self::LIVE;

    $postUrl .= $this->path;
    $this->addData('userName', $this->configuration->getUsername());
    $this->addData('password', $this->configuration->getPassword());

    if ($client_id = $this->configuration->getClientId()) {
      $this->addData('clientId', $client_id);
    }

    $url_data = $this->buildData($this->data);
    $url_data['password'] = $this->configuration->getPassword();
print_r($url_data);
    try {
      $response = $this->client->request('POST', $postUrl, [
        'query' => $url_data,
        'debug' => true
      ]);

      if ($response->getStatusCode() !== 200) {
        throw new ArcaException(sprintf('The request returned with error code %s', $response->getStatusCode()));
      } elseif (!$response->getBody()) {
        throw new ArcaException('The request did not have a body');
      }
    } catch (RequestException  $e) {
      throw new ArcaException($e->getMessage(), $e->getCode(), $e);
    }

    return new JsonResponse($response);
  }

  public function buildData($data) {
    if (empty($data)) {
      return;
    }

    $query_string = [];

    foreach ($data as $key => $value) {
      if (is_array($value)) {
        $sub = $this->buildData($value);
        if (!empty($sub)) {
          $query_string = $query_string + $sub;
        }
      } else {
        $query_string[$key] = $value;
      }
    }

    return $query_string;
  }
}
