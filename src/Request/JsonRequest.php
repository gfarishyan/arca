<?php

namespace Gfarishyan\Arca\Request;

use Gfarishyan\Arca\Configuration;

class JsonRequest extends BaseRequest {

  public function getContentType()
  {
    return 'application/json';
  }

  public function getBody() {
    return json_encode([$this->type => $this->data]);
  }
}
