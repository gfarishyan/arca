<?php

namespace Arca;

class Configuration {

  protected string $username;

  protected string $password;

  protected ?string $clientId;

  //protected string $clientSecret;

  protected string $mode;

  public function __construct(array $config) {
    foreach (['username', 'password', 'client_id', 'mode'] as $key) {
      if (!isset($config[$key])) {
        //raise exception
      }
    }

    $this->username = $config['username'];
    $this->password = $config['password'];
    $this->clientId = $config['client_id'] ?? null;
    $this->mode = $config['mode'];
  }

  public function getUsername(): string {
    return $this->username;
  }

  public function setUsername(string $username): Configuration
  {
    $this->username = $username;
    return $this;
  }

  public function getPassword(): string {
    return $this->password;
  }

  public function setPassword(string $password): Configuration
  {
    $this->password = $password;
    return $this;
  }

  public function getClientId(): ?string {
    return $this->clientId;
  }

  public function setClientId(string $clientId): Configuration {
    $this->clientId = $clientId;
    return $this;
  }

  public function getMode(): string {
    return $this->mode;
  }

  public function setMode(string $mode): Configuration {
    $this->mode = $mode;
    return $this;
  }

  public function isSandbox() {
    return ($this->mode === 'sandbox');
  }
}
