<?php

class SessionMirrorApi
{
    private $token = null;

    private $token_cache_key = 'session_mirror_access_token';
    private $token_cache_expire_seconds = 7200;

    private $form_filters_cache_key = 'session_mirror_form_params';
    private $form_filters_cache_expire_seconds = 600;

    private $api_url = 'https://x.sessionmirror.com';

    public function create_project($site)
    {
        $response = $this->request(
            '/v1/user/projects/create',
            array(
                'name' => $site,
                'type' => 'WORDPRESS',
                'version' => get_bloginfo('version')),
            $this->defaultHeaders(),
            'POST'
        );
        return json_decode($response, true);
    }

    public function projects()
    {
        $response = $this->request(
            '/v1/user/projects/list',
            array("x" => 1),
            $this->defaultHeaders(),
            'POST'
        );
        return json_decode($response, true);
    }

    public function video_filters($projectId)
    {
        $response = get_transient($this->form_filters_cache_key);

        if (!$response) {
            $response = $this->request(
                '/v1/session/filters/' . $projectId,
                array(),
                $this->defaultHeaders(),
                'GET'
            );

            set_transient($this->form_filters_cache_key, $response, $this->form_filters_cache_expire_seconds);
        }

        return json_decode($response, true);
    }

    public function videos($filters, $projectId)
    {
        $filters['projectId'] = $projectId;
        $response = $this->request(
            '/v1/session/list',
            $filters,
            $this->defaultHeaders(),
            'POST'
        );
        return json_decode($response, true);
    }

    public function video_records($filters)
    {
        $response = $this->request(
            '/v1/session/record/list',
            array("sessionId" => $filters['id']),
            $this->defaultHeaders(),
            'POST'
        );
        $json = json_decode($response, true);
        $json['token'] = $this->token;
        return $json;
    }

    public function set_access_token($apiKey, $secret)
    {
        $_token = $this->get_cache();
        if ($_token) {
            $this->token = $_token;
            return $_token;
        }

        $authorization = base64_encode($apiKey . ":" . $secret);
        $response = $this->request(
            '/oauth/token?grant_type=client_credentials',
            array("x" => 1),
            array("authorization: Basic " . $authorization),
            'POST'
        );
        $json = json_decode($response);
        if ($json && isset($json->access_token)) {
            $this->token = $json->access_token;
            $this->set_cache();
            return true;
        }
        return false;
    }

    private function request($path, $body, $headers = array(), $method = 'GET')
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->api_url . $path,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POSTFIELDS => json_encode($body),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }

    private function set_cache()
    {
        set_transient($this->token_cache_key, $this->token, $this->token_cache_expire_seconds);
    }

    private function get_cache()
    {
        return get_transient($this->token_cache_key);
    }

    private function defaultHeaders()
    {
        return array(
            'authorization: Bearer ' . $this->token,
            "content-type: application/json",
        );
    }

}
