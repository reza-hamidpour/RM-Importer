<?php
/**
 * User: Ray Hamidpour
 * Date: 7/11/18
 * Time: 3:41 PM
 */
require_once(dirname(__FILE__) . '/../api_request/request.class.php');

class RmPro extends request_api
{
    private $userName;
    private $pass;
    private $application;
    private $accCode;
    private $accKey;
    private $contentType;
    private $token;


    public function __constractor($userName, $pass, $server, $port, $services, $params, $method, $application, $portNum, $accCode, $accKey, $contentType)
    {
        parent::__construct($server, $portNum, $services, $params, $method);
        $this->userName = $userName;
        $this->pass = $pass;
        $this->accCode = $accCode;
        $this->accKey = $accKey;
        $this->contentType = $contentType;
        $this->application = $application;
        $this->setBodyRequest();
        $this->setHeaderRequest(true);
        $token = $this->requestApi(50);
        $this->setToken($token);
    }

    public function setBodyRequest()
    {
        $this->bodyRequest = '{
                     "username" : "' . $this->userName . '",
                     "password" : "' . $this->pass . '",
                     "application" : "' . $this->application . '"
                              }';
    }

    public function setHeaderRequest($login = false)
    {
        if ($login) {
            $this->headerRequest = array(
                "RMP-ACCESS-CODE:" . $this->accCode,
                "RMP-ACCESS-KEY:" . $this->accKey,
                "Content-Type:" . $this->contentType
            );
        } else if (!$login) {
            $this->headerRequest = array(
                "RMP-ACCESS-CODE:" . $this->accCode,
                "RMP-ACCESS-KEY:" . $this->accKey,
                "Content-Type:" . $this->contentType,
                "RMP-TOKEN:" . $this->token
            );
        }

    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getUrl()
    {
        return $this->urlRequest;
    }

    public function getBodyRequest()
    {
        return $this->bodyRequest;
    }

    public function getHeaderRequest()
    {
        return $this->headerRequest;
    }

    public function getToken()
    {
        return $this->token;
    }


    public function requestApi($timeOut = 30)
    {
        $curl_ob = curl_init();
        curl_setopt($curl_ob, CURLOPT_URL, $this->getUrl() . "/" . $this->getServices() . "?" . $this->getParams());
        curl_setopt($curl_ob, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_ob, CURLOPT_CUSTOMREQUEST, $this->getMethod());
        curl_setopt($curl_ob, CURLOPT_POSTFIELDS, $this->getBodyRequest());
        curl_setopt($curl_ob, CURLOPT_HTTPHEADER, $this->getHeaderRequest());
        curl_setopt($curl_ob, CURLOPT_TIMEOUT, $timeOut);
        $requestResult = curl_exec($curl_ob);
        curl_close($curl_ob);
        if ($this->getServices() !== "login")
            $requestResult = str_replace("\\", "/", $requestResult);
        if (is_array($requestResult)) {
            return json_decode($requestResult);
        } else {
            return false;
        }

    }


}
