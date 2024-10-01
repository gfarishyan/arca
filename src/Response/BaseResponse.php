<?php

namespace Arca\Response;

use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

abstract class BaseResponse implements ResponseInterface {
  /**
   * @var \Psr\Http\Message\ResponseInterface
   */
  protected $response;

  /**
   * @var mixed
   */
  protected $contents;

  public function __construct(HttpResponseInterface $response) {
    $this->response = $response;
  }

  public function contents() {
    return $this->contents;
  }

  public function getResultCode() {
    return $this->contents->messages->resultCode;
  }

  public function getMessages() {
    return $this->contents->messages->messages;
  }

  public function getMessageCode() {

  }

  public abstract function getErrors();

  public abstract function hasErrors();



  public function __isset($name)
  {
    return isset($this->contents->$name);
  }

  public function __get($name)
  {
    return $this->contents->$name;
  }
}
