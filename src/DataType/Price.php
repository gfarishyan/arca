<?php

namespace Arca\DataType;

class Price {

  public const CURRENCY_CODES = [
    'EUR' => '978',
    'USD' => '840',
    'RUB' => '643',
    'AMD' => '051'
  ];

  public $value;

  public $currency_code;

  public function __construct($value=NULL, $currency='AMD')
  {
    $currency = mb_strtoupper($currency);
    assert(isset(self::CURRENCY_CODES[$currency]), 'Invalid currency code');

    $this->value = $value;
    $this->currency_code = $currency;
  }

  public function toArray() :array {
    return [
      'value' => $this->value,
      'currency_code' => $this->currency_code,
    ];
  }

  public static function parseFromRaw($value, $currency) :Price {
    $codes = array_flip(self::CURRENCY_CODES);
    return new Price(($value / 100.00), $codes[$currency]);
  }

  public function toRaw() :array {
    return [
      'value' => $this->value * 100,
      'currency_code' => self::CURRENCY_CODES[$this->currency_code],
    ];
  }
}
