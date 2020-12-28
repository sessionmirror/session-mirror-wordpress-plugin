<?php

/**
 * @package session-mirror-wordpress-plugin
 * @version v1.0.0
 */

/*
Plugin Name: Session Mirror
Plugin URI: http://wordpress.org/plugins/session-mirror
Description: Session Mirror wordpress plugin.
Author: Session Mirror
Version: 1.0.0
Author URI: https://sessionmirror.com
*/

if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define('SESSION_MIRROR_PLUGIN_NAME', 'session-mirror-wordpress-plugin');
define('SESSION_MIRROR_PLUGIN_VERSION', 'v1.0.0');
define('SESSION_MIRROR_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SESSION_MIRROR_PLUGIN_FILE', __FILE__);
define('SESSION_MIRROR_PLUGIN_LANG_DOMAIN', 'session-mirror');

require_once SESSION_MIRROR_PLUGIN_DIR . 'class.session-mirror.php';
require_once SESSION_MIRROR_PLUGIN_DIR . 'class.session-mirror-views.php';
require_once SESSION_MIRROR_PLUGIN_DIR . 'class.session-mirror-api.php';

$session_mirror = new SessionMirror(
    new SessionMirrorApi(),
    new SessionMirrorViews()
);

$session_mirror->init();
