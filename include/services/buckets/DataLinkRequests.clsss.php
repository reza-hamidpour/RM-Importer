<?php
/**
 * Created by PhpStorm.
 * User: Reza
 * Date: 8/13/2018
 * Time: 4:12 PM
 */
require_once(dirname(__FILE__) . "/../api_request/request.class.php");

class DataLinkRequests extends request_api
{
    private $token;
    private $email;
    private $serverResponse;

    function __construct($server, $port, $services, $params, $method, $token, $email)
    {
        parent::__construct($server, $port, $services, $params, $method);

        $this->setEmail($email);
        $this->setToken($token);

    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setHeaderRequest()
    {
        if (!empty($this->token) && !empty($this->email)) {
            $this->headerRequest = "";
        } else {
            $this->headerRequest = '{
                            token : ' . $this->token . ',
                            email : ' . $this->email . '
                            }';
        }
    }

    public function setBodyRequest()
    {
        $this->bodyRequest = "";
    }

    public function getHeaderRequest()
    {
        return $this->headerRequest;
    }

    public function getBodyRequest()
    {
        return $this->bodyRequest;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function requestApi($timeOut = 30)
    {
        $curl_ob = curl_init();
        curl_setopt($curl_ob, CURLOPT_URL, $this->getUrlRequest() . "/" . $this->getServices() . "?" . $this->getParams());
        curl_setopt($curl_ob, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_ob, CURLOPT_CUSTOMREQUEST, $this->getMethod());
        curl_setopt($curl_ob, CURLOPT_POSTFIELDS, $this->getBodyRequest());
        curl_setopt($curl_ob, CURLOPT_HTTPHEADER, $this->getHeaderRequest());
        curl_setopt($curl_ob, CURLOPT_TIMEOUT, $timeOut);
        $requestResult = curl_exec($curl_ob);
        curl_close($curl_ob);
        $this->serverResponse = str_replace("\\", "/", $requestResult);
    }

    public function getServerResponse()
    {
        return $this->serverResponse;
    }

}