<?php

namespace Arca;

use Arca\Request\BaseRequest;

class OrderAuhorizeRequest extends RegisterOrderRequest {
  protected $path = '/registerPreAuth.do';

}
