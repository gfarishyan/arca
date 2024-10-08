<?php

namespace Gfarishyan\Arca\DataType;

interface DataTypeInterface {
  public function getType();
  public function toArray();
  public function addData($name, $value);
  public function addDataType(DataTypeInterface $data);
}
