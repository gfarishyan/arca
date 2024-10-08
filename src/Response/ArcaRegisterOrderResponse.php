<?php

namespace Gfarish\arca\Response;

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
      return $this->errorCode;
  }

  public function setErrorCode(int $errorCode): ArcaResponse {
      $this->errorCode = $errorCode;
      return $this;
  }

  public function getErrorMessage(): string {
      return $this->errorMessage;
  }

  public function setErrorMessage(string $errorMessage): ArcaResponse
  {
    $this->errorMessage = $errorMessage;
    return $this;
  }

  public function hasError(): bool {
    return !empty($this->errorCode);
  }

  public function getResponse(): array {
      return $this->response;
  }

}
