<?php

namespace Gfarishyan\Arca\Response;

class ArcaRegisterOrderResponse {

  protected int $errorCode;
  protected string $errorMessage;

  protected array $response;

  public function __construct(array $response=[]) {
    $this->response = $response;
    if (!empty($response['errorCode'])) {
        $this->errorCode = $response['errorCode'];
    }

    if (!empty($response['Error'])) {
      $this->errorMessage = $response['Error'];
    }

  }

  public function getErrorCode(): int {
      return (int) $this->errorCode;
  }

  public function setErrorCode(int $errorCode): ArcaResponse {
      $this->errorCode = $errorCode;
      return $this;
  }

  public function getErrorMessage(): string {
      //in general we can assume tha payment gaeway will return the error message.
      //anyway we decode message
      $error_code = $this->getErrorCode();
      $error_msg = match($error_code) {
          0 => 'request successfully processed.',
          1 => 'there is already exists order with same order number.',
          3 => 'Unknown currency.',
          4 => 'there is missng one of required parameters: orderNumber, merchant username, amount can not be empty, returnng url is empty, passwod can not be empty.',
          5 => 'wrong amount, wrong order number, unknon merchant, access denied, account disabled.',
          7 => 'system error',
      };

      return $this->errorMessage ? $this->errorMessage : $error_msg;
  }

  public function setErrorMessage(string $errorMessage): ArcaResponse
  {
    $this->errorMessage = $errorMessage;
    return $this;
  }

  public function hasError(): bool {

      if (!isset($this->errorCode)) {
        return false;
      }
      $error = match((int)$this->errorCode) {
        0 => false,
        1 => true,
        3 => true,
        4 => true,
        5 => true,
        7 => true,
      };
    return $error;
  }

  public function getResponse(): array {
      return $this->response;
  }

  public function getRedirectUrl() {
      return $this->response['formUrl'];
  }

  public function getOrderId() {
    return $this->response['orderId'];
  }
}
