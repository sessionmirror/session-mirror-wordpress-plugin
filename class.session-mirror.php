<?php

class SessionMirror
{
    /** @var SessionMirrorApi */
    private $api;

    /** @var SessionMirrorViews */
    private $views;

    private $option_key = 'session_mirror_options';

    private $language_files_path = 'languages';

    public function __construct($api, $views)
    {
        $this->api = $api;
        $this->views = $views;
    }

    public function init()
    {
        load_plugin_textdomain(
            SESSION_MIRROR_PLUGIN_LANG_DOMAIN,
            false,
            SESSION_MIRROR_PLUGIN_NAME . '/' . $this->language_files_path
        );

        add_action('admin_menu', array($this, 'main_menu'));
        add_action("wp_ajax_session_mirror", array($this, 'ajax'));
        add_action('admin_enqueue_scripts', array($this, 'load_scripts'));
        add_action('wp_footer', array($this, 'site_tracking_code'), 100);

        register_activation_hook(SESSION_MIRROR_PLUGIN_FILE, array($this, 'plugin_activation'));
        register_activation_hook(SESSION_MIRROR_PLUGIN_FILE, array($this, 'plugin_deactivation'));
    }

    public function main_menu()
    {
        add_menu_page(
            'Session Mirror',
            'Session Mirror',
            'administrator',
            'session-mirror',
            array($this, 'main_page'),
            'dashicons-video-alt2',
            100
        );

        add_submenu_page(
            'session-mirror',
            'Session Mirror',
            __('Dashboard', SESSION_MIRROR_PLUGIN_LANG_DOMAIN),
            'administrator',
            'session-mirror',
            array($this, 'main_page')
        );

        add_submenu_page(
            'session-mirror',
            'Session Mirror Settings',
            __('Settings', SESSION_MIRROR_PLUGIN_LANG_DOMAIN),
            'manage_options',
            'session-mirror-settings',
            array($this, 'settings_page')
        );
    }

    public function main_page()
    {
        if (!is_admin()) {
            die(__('Permission denied', SESSION_MIRROR_PLUGIN_LANG_DOMAIN));
        }

        echo '<div class="wrap">';
        printf('<h1 class="wp-heading-inline">%s</h1>', __('Session Mirror Dashboard', SESSION_MIRROR_PLUGIN_LANG_DOMAIN));
        echo '<hr class="wp-header-end"/>';
        echo '<hr/>';

        if (get_option($this->option_key)) {
            $this->views->video_list();
        } else {
            $this->views->please_log_in_first_notice();
        }

        echo '</div>';
    }

    public function settings_page() {
        if (!is_admin()) {
            die(__('Permission denied', SESSION_MIRROR_PLUGIN_LANG_DOMAIN));
        }

        if (isset($_GET['reset-settings'])) {
            $this->refresh_options();
        }

        echo '<div class="wrap">';
        printf('<h1 class="wp-heading-inline">%s</h1>', __('Session Mirror Settings', SESSION_MIRROR_PLUGIN_LANG_DOMAIN));
        echo '<hr class="wp-header-end"/>';
        echo '<hr/>';

        if (isset($_POST['_wpnonce_session-mirror-settings'])
            && wp_verify_nonce( $_POST['_wpnonce_session-mirror-settings'], 'session-mirror-settings' ) ) {

            $saved = $this->save_settings();
            if ($saved) {
                $this->views->settings_saved_successfully_notice();
            } else {
                $this->views->settings_could_not_be_saved_notice();
            }
        }

        $form_values = array();
        if ($options = get_option($this->option_key)) {
            $form_values = $options;
        }
        $this->views->settings_form($form_values);

        echo '</div>';
    }

    public function save_settings()
    {
        $api_key = sanitize_text_field($_POST['session_mirror_api_key']);
        $secret = sanitize_text_field($_POST['session_mirror_secret']);
        $site = sanitize_text_field($_POST['session_mirror_site']);
        $status = sanitize_text_field($_POST['session_mirror_site_status']);
        $media_player_type = sanitize_text_field($_POST['session_mirror_media_player_type']);

        $this->refresh_options();

        // check token
        $is_valid_credentials = $this->api->set_access_token($api_key, $secret);
        if (!$is_valid_credentials) {
            return false;
        }

        // check site
        $projects = $this->api->projects();
        if (!isset($projects['response']['projects'])) {
            return false;
        }
        $parsed_url = parse_url($site);
        if (!isset($parsed_url['host'])) {
            return false;
        }
        $project_found = null;
        foreach ($projects['response']['projects'] as $project) {
            if ($project['name'] === $parsed_url['host']) {
                $project_found = $project;
                break;
            }
        }

        // create site
        if (!$project_found) {
            $created = $this->api->create_project($parsed_url['host']);
            if (!isset($created['code']) || $created['code'] !== 100) {
                return false;
            }
            $projects = $this->api->projects();
            if (!isset($projects['response']['projects'])) {
                return false;
            }
            foreach ($projects['response']['projects'] as $project) {
                if ($project['name'] === $parsed_url['host']) {
                    $project_found = $project;
                    break;
                }
            }
        }

        $data = array(
            'api_key' => $api_key,
            'secret' => $secret,
            'project_id' => $project_found['id'],
            'domain' => $site,
            'status' => $status,
            'media_player_type' => $media_player_type,
        );

        add_option($this->option_key, $data);
        return true;
    }

    public function ajax()
    {
        $function = sanitize_text_field($_POST['function']);

        $data = isset($_POST['data']) ? $_POST['data'] : array();

        foreach ($data as $key => $value) {
            $data[$key] = sanitize_text_field($value);
        }

        $options = get_option($this->option_key);
        $project_id = isset($options['project_id']) ? $options['project_id'] : null;

        $access_token = $this->api->set_access_token($options['api_key'], $options['secret']);
        if (!$access_token) {
            die(json_encode(array('error' => 'Access token error')));
        }

        $response = '';

        switch ($function) {
            case 'video_filters':
                $response = json_encode($this->api->video_filters($project_id));
                break;

            case 'videos':
                if (isset($data['_wpnonce_session-mirror-video-filters'])
                    && ! wp_verify_nonce($data['_wpnonce_session-mirror-video-filters'], 'session-mirror-video-filters')) {

                    die(json_encode(array('error' => 'Invalid form data')));
                }
                unset($data['_wpnonce_session-mirror-video-filters']);
                unset($data['_wp_http_referer']);

                $response = json_encode($this->api->videos($data, $project_id));
                break;

            case 'video_records':
                $response = json_encode($this->api->video_records($data, $options['media_player_type']));
                break;

            case 'basic_stats':
                $response = json_encode($this->api->basic_stats());
                break;
        }

        exit($response);
    }

    public function load_scripts()
    {
        wp_enqueue_script('session_mirror_script', plugin_dir_url(__FILE__) . 'assets/session-mirror-admin.js', array('jquery'), '1.0');
        wp_localize_script('session_mirror_script', 'session_mirror_ajax', array('ajax_url' => admin_url('admin-ajax.php')));

        wp_enqueue_style('fontawesome', 'https://use.fontawesome.com/releases/v5.8.1/css/all.css', '', '5.8.1', 'all');
        wp_enqueue_style('session_mirror_icomoon', plugins_url(SESSION_MIRROR_PLUGIN_NAME . '/assets/icomoon/styles.css'));
        wp_enqueue_style('session_mirror', plugins_url(SESSION_MIRROR_PLUGIN_NAME . '/assets/session-mirror.css'));
    }

    public function site_tracking_code()
    {
        $options = get_option($this->option_key);
        $project_id = isset($options['project_id']) ? $options['project_id'] : null;
        $is_site_active = isset($options['status']) && $options['status'] === 'ACTIVE';

        if ($project_id && $is_site_active) {
            echo '<script type="text/javascript">';
            echo '(function(s,m){var kv=function(k,v){s.sessionRecorder[k]=v};s.sessionRecorder=s.sessionRecorder||{};s.sessionMirror=s.sessionMirror||kv;var a=m.createElement("script");a.type="text/javascript";a.async=true;a.src="https://client.sessionmirror.com/recorder.js";m.getElementsByTagName("head")[0].appendChild(a);})(window, document);';
            echo 'sessionMirror("id", "' . $project_id . '");';
            echo '</script>';
        }
    }

    private function refresh_options() {
        delete_option($this->option_key);
        $this->api->refresh_cache();
    }

    public function plugin_activation()
    {
        //
    }

    public function plugin_deactivation()
    {
        //
    }

}
