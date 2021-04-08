<?php

require_once 'TransactionRequest.php';

class BankSlipRequest extends TransactionRequest
{

    public function __construct($jwt,$isProduction = true)
    {   
        parent::__construct("bankSlip", $jwt, $isProduction);
    }

    public function send($data)
    {
        return json_encode(parent::send($data));
    }

    public function get($id)
    {
        try {
            $curl = curl_init();
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_HTTPHEADER, array($this->authorization));
            curl_setopt($curl, CURLOPT_URL, $this->url.'/'.$id);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $return['httpCode'] = $httpcode;
            $return['response'] = $result;
            return $return;
        } catch (Exception $e) {

        }
    }
}
