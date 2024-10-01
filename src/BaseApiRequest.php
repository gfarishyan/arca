<?php

namespace Arca;

use Arca\Request\RequestInterface;
use Arca\Request\JsonRequest;
use GuzzleHttp\Client;


abstract class BaseApiRequest
{
  /**
   * @var \Arca\Configuration
   */
  protected $configuration;


  /**
   * @var \GuzzleHttp\Client
   */
  protected $client;

  protected $path;

  public function __construct(Configuration $configuration, Client $client) {
    $this->configuration = $configuration;
    $this->client = $client;
  }

  abstract protected function attachData(RequestInterface $request);

  public function execute() {
    $request = new JsonRequest($this->configuration, $this->client, $this->path);
    $this->attachData($request);
    $response = $request->sendRequest();

    return $response;
  }
}
