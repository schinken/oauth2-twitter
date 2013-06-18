<?php

require_once 'Request.php';

class Twitter_API {

    private $access_token = false;

    public function set_access_token($access_token) {
        $this->access_token = $access_token;
    }

    public function get_access_token($consumer_key, $consumer_key_secret) {

        $base64_token = base64_encode($consumer_key.':'.$consumer_key_secret);

        $req = new Twitter_Request('oauth2/token');

        $req->set_header('Authorization', 'Basic '.$base64_token);
        $req->set_request_field('grant_type', 'client_credentials');

        $data = $req->send_request();

        if(!isset($data['token_type']) || $data['token_type'] != 'bearer') {
            throw new Exception("token type doesn't exist or is no bearer");
        }

        if(!isset($data['access_token']) || empty($data['access_token'])) {
            throw new Exception('missing bearer token in response');
        }

        $this->set_access_token($data['access_token']);

        return $data['access_token'];
    }


    public function get($resource, $data = array()) {
        return $this->send_request($resource, 'GET', $data);
    }

    public function post($resource, $data = array()) {
        return $this->send_request($resource, 'POST', $data);
    }

    private function send_request($resource, $method, $data) {

        if($this->access_token === false) {
            throw new Exception('You need to set or retrieve an access token first');
        }
        
        $req = new Twitter_Request($resource, $method);
        $req->set_request_fields($data);
        $req->set_header('Authorization', 'Bearer '.$this->access_token);

        return $req->send_request();
    }
}

