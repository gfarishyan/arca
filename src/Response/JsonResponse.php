<?php

namespace Gfarishyan\Arca\Response;

use Gfarishyan\Arca\Exception\ArcaException;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

class JsonResponse extends BaseResponse {

  public function __construct(HttpResponseInterface $response) {
    parent::__construct($response);
    $content = $response->getBody()->getContents();
    $content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);
    $content = json_decode($content, true);
    if (json_last_error() !== JSON_ERROR_NONE) {
      throw new ArcaException(sprintf("JSON returned from API was not decoded: %s", json_last_error_msg()));
    }

    $this->contents = $content;
  }

  public function hasErrors() {
    return !empty($this->contents['errorCode']);
  }

  public function getErrors() {
    return $this->contents['errorCode'];
  }

  public function getErrorMessage() {
    return $this->contents['errorMessage'];
  }


  public function getResultCode() {

  }

  public function toArray()
  {
      return $this->contents;
  }
}
