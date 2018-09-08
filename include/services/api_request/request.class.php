<?php
/**
 * Created by RM Innovation.
 * User: Ray
 * Date: 7/10/2018
 * Time: 12:00 PM
 */

abstract class request_api
{

    protected $bodyRequest;
    protected $headerRequest;
    protected $server;
    protected $portNum;
    protected $urlRequest;
    protected $services;
    protected $params;
    protected $method;


    function __construct($server, $port, $services, $params, $method)
    {
        $this->setServer($server);
        $this->setPortNum($port);
        $this->setServices($services);
        $this->setParams($params);
        $this->setMethod($method);
        $this->setUrlRequest();
    }

    public function setPortNum($portNum)
    {
        $this->portNum = $portNum;
    }

    public function setServer($server)
    {
        $this->server = $server;
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function setServices($services)
    {
        $this->services = $services;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function setUrlRequest()
    {
        $this->urlRequest = $this->server . ":" . $this->portNum;
    }

    abstract public function setBodyRequest();

    abstract public function setHeaderRequest();

    public function getPortNum()
    {
        return $this->portNum;
    }

    public function getServer()
    {
        return $this->server;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getUrlRequest()
    {
        return $this->urlRequest;
    }

    public function getServices()
    {
        return $this->services;
    }

    public function getParams()
    {
        return $this->params;
    }

    public function getMethod()
    {
        return $this->method;
    }

    abstract public function getHeaderRequest();

    abstract public function getBodyRequest();

    abstract public function requestApi($timeOut = 30);
//   protected function requestApi($url ,$body = "{}" , $header = "", $service,$params = "",$method = "GET",$timeOut = 30)
//     {
//         $curl_ob = curl_init();
//             curl_setopt($curl_ob, CURLOPT_URL ,$url."/".$service."?".$params);
//             curl_setopt($curl_ob , CURLOPT_RETURNTRANSFER ,1);
//             curl_setopt($curl_ob , CURLOPT_CUSTOMREQUEST , $method);
//             curl_setopt($curl_ob , CURLOPT_POSTFIELDS , $body);
//             curl_setopt($curl_ob , CURLOPT_HTTPHEADER , $header);
//             curl_setopt($curl_ob , CURLOPT_TIMEOUT , $timeOut);
//                 $requestResult = curl_exec($curl_ob);
//                 if($service !== "login")
//                     $requestResult = str_replace("\\" , "/" , $requestResult);
//         curl_close($curl_ob);
//         return json_decode($requestResult);
//     }
}
