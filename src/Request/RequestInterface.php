<?php

namespace Arca\Request;

interface RequestInterface {
  /**
   * Get the request's Content-Type header value.
   * @return string
   */
  public function getContentType();

  /**
   * Gets the request's body payload.
   *
   * @return string
   */
  public function getBody();

  /**
   * @param $name
   * @param $value
   */
  public function addData($name, $value);

  public function sendRequest();
}
