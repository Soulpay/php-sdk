<?php

require_once 'TransactionRequest.php';

class RecurringRequest extends TransactionRequest
{

    public function __construct($jwt, $isProduction = true)
    {
        parent::__construct("recurrence", $jwt, $isProduction);
    }

    public function send($data)
    {
        return json_encode(parent::send($data));
    }

    public function delete($data)
    {
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $this->authorization));
            curl_setopt($curl, CURLOPT_URL, $this->url.'/'.$data->getOrderId());
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $return['httpCode'] = $httpcode;
            $return['response'] = $result;
            return $return;
        } catch (Exception $e) {
        }
    }

    public function put($data)
    {
        try {
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $this->authorization));
            curl_setopt($curl, CURLOPT_URL, $this->url);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            $result = curl_exec($curl);
            $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $return['httpCode'] = $httpcode;
            $return['response'] = $result;
            return $return;
        } catch (Exception $e) {
        }
    }

    public function get($id)
    {
        try {
            $curl = curl_init();
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_HTTPHEADER, array($this->authorization));
            curl_setopt($curl, CURLOPT_URL, $this->url.'/'.'list/'.$id);
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
