<?php

namespace Gfarishyan\Arca;

use Gfarishyan\Arca\Request\BaseRequest;

class OrderAuhorizeRequest extends RegisterOrderRequest {
  protected $path = '/registerPreAuth.do';

}
