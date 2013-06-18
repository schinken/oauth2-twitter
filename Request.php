<?php

require_once 'JSON.php';

class Twitter_Request {

    private $base_url = 'https://api.twitter.com/';
    private $headers = array();
    private $request_fields = array();

    private $resource = '';
    private $method = 'POST';

    public function __construct($resource, $method = 'POST') {
        $this->resource = $resource;
        $this->method = $method;
    }

    public function set_header($key, $value) {
        $this->headers[$key] = sprintf("%s: %s", $key, $value);
    }

    public function set_headers(array $headers) {
        foreach($headers as $key => $value) {
            $this->set_header($key, $value);
        }
    }

    public function set_request_field($key, $value) {
        $this->request_fields[$key] = $value;
    }

    public function set_request_fields(array $fields) {
        foreach($fields as $key => $value) {
            $this->set_request_field($key, $value);
        }
    }

    public function send_request() {
    
        $req = '';
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_values($this->headers));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if($this->method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, 1);
        }

        if(!empty($this->request_fields)) {
            if($this->method == 'POST') {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->request_fields);
            } else {
                $req = '?' . http_build_query($this->request_fields);
            }
        }

        curl_setopt($ch, CURLOPT_URL, $this->base_url.$this->resource.$req);


        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($http_code !== 200) {
            throw new Exception('Twitter API responded with http code '.$http_code);
        }

        $response = JSON::decode($result);

        curl_close($ch);

        return $response;
    }
}   
