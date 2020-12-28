<?php

class SessionMirrorApi
{
    private $token = null;

    private $token_cache_key = 'session_mirror_access_token';
    private $token_cache_expire_seconds = 7200;

    private $form_filters_cache_key = 'session_mirror_form_params';
    private $form_filters_cache_expire_seconds = 600;

    private $basic_stats_cache_key = 'session_mirror_basic_stats';
    private $basic_stats_cache_expire_seconds = 300;

    private $api_url = 'https://x.sessionmirror.com';
    private $GET = 'GET';
    private $POST = 'POST';

    public function create_project($site)
    {
        return $this->request(
            '/v1/user/projects/create',
            array(
                'name' => $site,
                'type' => 'WORDPRESS',
                'version' => get_bloginfo('version')),
            $this->defaultHeaders(),
            $this->POST
        );
    }

    public function projects()
    {
        return $this->request(
            '/v1/user/projects/list',
            array("x" => 1),
            $this->defaultHeaders(),
            $this->POST
        );
    }

    public function video_filters($projectId)
    {
        $response = get_transient($this->form_filters_cache_key);

        if (!$response) {
            $response = $this->request(
                '/v1/session/filters/' . $projectId,
                array(),
                $this->defaultHeaders(),
                $this->GET
            );

            set_transient($this->form_filters_cache_key, $response, $this->form_filters_cache_expire_seconds);
        }

        return $response;
    }

    public function videos($filters, $projectId)
    {
        $filters['projectId'] = $projectId;
        return $this->request(
            '/v1/session/list',
            $filters,
            $this->defaultHeaders(),
            $this->POST
        );
    }

    public function video_records($filters, $media_player_type)
    {
        $response = $this->request(
            '/v1/session/record/list',
            array("sessionId" => $filters['id']),
            $this->defaultHeaders(),
            $this->POST
        );
        $response['token'] = $this->token;
        $response['media_player_type'] = $media_player_type;
        return $response;
    }

    public function basic_stats()
    {
        $response = get_transient($this->basic_stats_cache_key);

        if (!$response) {
            $response = $this->request(
                '/v1/user/basic-stats',
                array("x" => 1),
                $this->defaultHeaders(),
                $this->GET
            );

            set_transient($this->basic_stats_cache_key, $response, $this->basic_stats_cache_expire_seconds);
        }

        return $response;
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
            array("authorization" => "Basic " . $authorization),
            $this->POST
        );
        if ($response && isset($response['access_token'])) {
            $this->token = $response['access_token'];
            $this->set_cache();
            return true;
        }
        return false;
    }

    private function request($path, $body, $headers = array(), $method = 'GET')
    {
        $url = $this->api_url . $path;

        $args = array(
            'body'        => json_encode($body),
            'timeout'     => '30',
            'redirection' => '0',
            'headers'     => $headers,
        );

        if ($method === $this->GET) {
            $response = wp_remote_get($url, $args);
        } else {
            $response = wp_remote_post($url, $args);
        }

        if (is_wp_error($response)) {
            return array('error' => $response->errors);
        }
        return json_decode($response['body'], true);
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
            'authorization' => 'Bearer ' . $this->token,
            'content-type' => 'application/json',
        );
    }

    public function refresh_cache() {
        delete_transient($this->token_cache_key);
        delete_transient($this->form_filters_cache_key);
        delete_transient($this->basic_stats_cache_key);
    }

}
