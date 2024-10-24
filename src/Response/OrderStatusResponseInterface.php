<?php

namespace Gfarishyan\Arca\Response;

interface OrderStatusResponseInterface {
    public const ORDER_STATUS_REGISTERED = 0;
    public const ORDER_STATUS_ONHOLD = 1;
    public const ORDER_STATUS_AUTHORIZED = 2;
    public const ORDER_STATUS_AUTHORIZATION_CANCELLED = 3;
    public const ORDER_STATUS_REFUNDED = 4;
    public const ORDER_STATUS_ACS_AUTHORIZE = 5;
    public const ORDER_STATUS_AUTHORIZE_DECLINED = 6;
}
