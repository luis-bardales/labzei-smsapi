<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//----------------------------------------------------------------------------
// REST Client for SMS-API from LABZEI
// ---------------------------------------------------------------------------
//
// @author    Luis Bardales
// @company   LABZEI -::- Mister Cloud S.A.C.
// @website   https://www.labzei.com/
// @product   CloudSMS
// @version   1.0
// @updated   26/08/2020
//----------------------------------------------------------------------------
class CloudsmsClient {

    private $_host;

    private $_apiKey;

    //----------------------------------------------------------------------------
    // Constructor - sets API config
    // ---------------------------------------------------------------------------
    // The constructor receives the Api Key
    //
    // @param   string $apiKey
    // @return  void
    //----------------------------------------------------------------------------
    public function __construct( $apiKey = '' )
    {

        $this->_host    = 'https://smsapi.labzei.net/';
        $this->_apiKey  = $apiKey;

    }

    //----------------------------------------------------------------------------
    // send - Send a sms message
    // ---------------------------------------------------------------------------
    //
    // @param   string $number
    // @param   string $message
    // @return  array
    //----------------------------------------------------------------------------
    public function send( $number = '', $message = '' )
    {

        $httpVerb   = 'POST';
        $method     = 'sms/send';

        $args = array(
            'number'    => $number,
            'message'   => $message,
        );

        $response = $this->_request( $httpVerb, $method, $args );

        if ($response['status'] == 202)
        {
            return array(
                'success'   => TRUE,
                'response'  => $response,
            );
        }

        return array(
            'success'   => FALSE,
            'response'  => $response,
        );

    }

    //----------------------------------------------------------------------------
    // Request - Makes a request
    // ---------------------------------------------------------------------------
    // Performs the HTTP request to the API
    //
    // @param   string $httpVerb
    // @param   string $method
    // @param   array  $args
    // @return  array
    //----------------------------------------------------------------------------
    private function _request($httpVerb, $method, $args = array())
    {

        $url = $this->_host.$method;

        $header = array(
            'Content-Type: application/json',
            'x-api-key: '.$this->_apiKey,
        );

        $ch     = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        if ($httpVerb == 'POST')
        {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($args));
        }

        $result = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        $response = array(
            'status' => (int) $status,
            'result' => $result ? json_decode($result, true) : false,
        );

        return $response;

    }

}