<?php

namespace Arca\DataType;

class BaseDataType implements DataTypeInterface {
  protected $map;

  public function __construct(array $values = []) {
    foreach ($values as $name => $value) {
      if (isset($this->map[$name])) {
        $this->$name = $value;
      }
    }
  }

  public function getType() {
    return lcfirst((new \ReflectionClass($this))->getShortName());
  }

  public function __set($name, $value) {
    $this->$name = $value;
  }

  public function __get($name) {
    return $this->$name;
  }

  public function __isset($name) {
    return isset($this->$name);
  }

  public function __unset($name) {
    unset($this->$name);
  }

  public function addData($name, $value) {
    $this->$name = $value;
  }

  public function addDataType(DataTypeInterface $data) {
    $data_type = $data->getType();
    $this->$data_type = $data->toArray();
  }

  public function toArray() {
    $return = [];
    foreach ($this->map as $key => $value) {
      if (isset($this->$key)) {
        $return[$value] = $this->$key;
      }
    }

    return $return;
  }
}
