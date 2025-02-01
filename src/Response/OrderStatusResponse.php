<?php

namespace Gfarishyan\Arca\Response;

class OrderStatusResponse implements OrderStatusResponseInterface {

    public const TRANSACTION_DECLINED = 6;

    protected int $errorCode;
    protected string $errorMessage;

    protected array $response;

    public function __construct(array $response=[]) {
        $this->response = $response;
    }

    public function hasError() :bool {
       return (isset($this->response['errorCode']) && !($this->response['errorCode'] === "0"));
    }

    public function getOrderNumber() :string {
      return $this->response['orderNumber'];
    }

    public function getOrderDescription() :string {
      return  $this->response['orderDescription'];
    }

    public function getCustomerIp() {
        return $this->response['ip'];
    }

    public function getOrderStatus() {
        return $this->response['orderStatus'];
    }

    public function getActionCode() {
        return $this->response['actionCode'];
    }

    public function getAmount() :int {
       return (int)$this->response['amount'];
    }

    public function getCurrency() :string {
      return (string)$this->response['currency'];
    }

    public function getRegistrationDate() :\DateTime
    {
        return \DateTime::createFromFormat('U', $this->response['date']);
    }

    public function getCardNumber() :string {
        return $this->response['cardAuthInfo']['pan'];
    }

    public function getCardHolder() :string {
      return $this->response['cardAuthInfo']['cardholderName'];
    }

    public function getCardExpirationDate() :\DateTime {
      return \DateTime::createFromFormat('Ym', $this->response['cardAuthInfo']['expiration']);
    }


    public function getCardType() {
        return 'visa';
    }


    public function getApprovalCode() :string {
        return $this->response['approvalCode'];
    }

    public function getTermnal()
    {
        return $this->response['terminalId'];
    }

    public function getPaymentState() {
        return $this->response['paymentAmountInfo']['paymentState'];
    }

    public function getApprovedAmount()
    {
        return $this->response['paymentAmountInfo']['approvedAmount'];
    }

    public function getDepositedAmount()
    {
        return $this->response['paymentAmountInfo']['depositedAmount'];
    }

    public function getRefundedAmount()
    {
        return $this->response['paymentAmountInfo']['refundedAmount'];
    }

    public function getBankName() {
        return $this->response['bankInfo']['bankName'];
    }

    public function getBankCountry() {
        return $this->response['bankInfo']['bankCountryCode'];
    }

    public function getBankCountryName() {
        return $this->response['bankInfo']['bankCountryName'];
    }

    public function getBinding() {
        if (empty($this->response['bindingInfo'])) {
            return null;
        }

        if (empty($this->response['bindingInfo']['bindingId'])) {
            return null;
        }
        $binding_id = $this->response['bindingInfo']['bindingId'];
        return $binding_id;
    }

    public function getAuthDate() {
        return \DateTime::createFromFormat('U', $this->response['authDate']);
    }

    public function getAuthRefNum()
    {
        return $this->response['authRefNum'];
    }

    public function canAuthorize() :bool|string {
        if ($this->hasError()) {
            return false;
        }

        $order_status = $this->getOrderStatus();

        if ($order_status == self::TRANSACTION_DECLINED) {
          return false;
        }

    }

    public function canCapture()
    {

    }

    public function canRefund() {

    }

    public function canCancel()
    {

    }

    //actionCodeDescription
    //errorCode
    //errorMessage
    //date
    //orderDescription
    //ip
    //pan, expiration, cardholderName, approvalCode, eci, cavv, xid, clientId, bindingId, authDateTime, authRefNum, terminalId
    //approvedAmount, depositedAmount, refundedAmount, paymentState, bankName, bankCountryCode, bankCountryName

}
