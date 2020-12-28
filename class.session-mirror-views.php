<?php

class SessionMirrorViews {

    public function video_filters_html() {
        echo '<div class="tablenav top">
               <div class="alignleft actions">
            <form method="get" action="" onsubmit="sessionMirrorVideosFilterForm(this); return false;" class="session-mirror-video-filter-form-s">
            ' . wp_nonce_field('session-mirror-video-filters', '_wpnonce_session-mirror-video-filters') . '
            <table class="table" id="session-mirror-video-filter-table"><tbody>
            <tr>
                <td><select name="browser">
                    <option value="">' . __('Browser', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</option>
                    <option >CHROME</option>
                    <option >FIREFOX</option>
                    <option >SAFARI</option>
                    <option >OPERA</option></select></td>
                  <td><select name="os">
                    <option value="">' . __('OS', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</option>
                    <option >MAC_OS_X</option>
                    <option >IOS</option>
                    <option >ANDROID</option>
                    <option >WINDOWS</option>
                    <option >UBUNTU</option>
                    </select></td>
                  <td><select name="device">
                    <option value="">' . __('Device', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</option>
                    <option value="COMPUTER">' . __('Computer', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</option>
                    <option value="MOBILE">' . __('Mobile', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</option>
                    </select></td>
                  <td><select name="country">
                    <option value="" id="country-text">' . __('Country', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</option></select></td>
                  <td><select name="city">
                    <option value="" id="city-text">' . __('City', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</option></select></td>
                  <td style="display:none;">
                    <div class="form-group">
                        <select class="tags_list">
                            <option value="" id="city-text">' . __('Tags', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</option>
                        </select>
                        <input type="text" class="tags" placeholder="' . __('Tag', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '"/>
                    </div>
                  </td>
                  <td><button class="button action" type="submit"><b><i class="icon-search4"></i></b> ' . __('Filter', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . ' </button></td>
                  <td><i class="fa fa-spinner fa-pulse session-mirror-form-loading-icon"></i></td>
                 </tr>
                 </tbody>
               </table>
               </div>
               <div class="session-mirror-video-remaining-d">
                ' . __('Remaining Videos', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . ': <span id="session-mirror-remaining-video-count">...</span>
                </div>
                <br class="clear"/>
            </form></div>';
    }

    public function video_pagination() {
        echo '<div class="tablenav bottom">
	        <div class="alignleft actions bulkactions"></div>
		    <div class="alignleft actions"></div>
		    <div class="tablenav-pages">
		        <i class="fa fa-spinner fa-pulse session-mirror-form-loading-icon" style="margin-left: 5px;"></i>
		        <span class="displaying-num session-mirror-video-pagination-number"></span>
                <span class="pagination-links">
                    <span class="tablenav-pages-navspan button session-mirror-video-pagination-first" onclick="sessionMirrorVideoPaginationFirst(this)">«</span>
                    <span class="tablenav-pages-navspan button session-mirror-video-pagination-prev" onclick="sessionMirrorVideoPaginationPrev(this)">‹</span>
                    <span id="table-paging" class="paging-input"><span class="tablenav-paging-text session-mirror-video-pagination-current-page"></span></span>
                    <span class="tablenav-pages-navspan button session-mirror-video-pagination-next" onclick="sessionMirrorVideoPaginationNext(this)">›</span>
                    <span class="tablenav-pages-navspan button session-mirror-video-pagination-last" aria-hidden="true" onclick="sessionMirrorVideoPaginationLast(this)">»</span>
                </span>
            </div>
		    <br class="clear">
	      </div>';
    }

    public function video_player_modal() {
        echo '<div class="theme-overlay" tabindex="0" role="dialog" id="session-mirror-video-player-container" style="display: none;">
            <input type="hidden" id="session-mirror-video-player-modal-session-id" value=""/>
            <input type="hidden" id="session-mirror-video-player-modal-page-count" value=""/>
            <div class="theme-overlay">
	            <div class="theme-backdrop"></div>
	            <div class="theme-wrap wp-clearfix" role="document" style="top:5% !important;">
		            <div class="theme-header">
			            <button class="left dashicons dashicons-no" onclick="sessionMirrorVideoPlayerModalPrevVideo()"></button>
			            <button class="right dashicons dashicons-no" onclick="sessionMirrorVideoPlayerModalNextVideo()"></button>
			            <span class="session-mirror-video-player-modal-info-video-count"></span>
			            <button class="close dashicons dashicons-no" onclick="sessionMirrorVideoPlayerModalClose()"></button>
		            </div>
		            <div class="theme-about wp-clearfix" style="bottom:0">
			            <div id="session-mirror-video-player-content"></div>
		            </div>
	            </div>
            </div>
        </div>';
    }

    public function video_list() {
        $this->video_filters_html();

        echo '<br/>';

        echo '<table class="wp-list-table widefat fixed striped table-view-list posts" id="session-mirror-video-list-table">
	            <thead>
	                <tr>
		                <th scope="col" class="manage-column column-author">' . __('Watch', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</th>
		                <th scope="col" class="manage-column column-author">' . __('Duration', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</th>
		                <th scope="col" class="manage-column column-categories">' . __('Browser / OS', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</th>
		                <th scope="col" class="manage-column column-tags">' . __('Location', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</th>
		                <th scope="col" class="manage-column column-tags">' . __('Pages', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</th>
		                <th scope="col" class="manage-column column-tags" style="display:none;">' . __('Tags', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</th>
		                <th scope="col" class="manage-column column-tags">' . __('Date', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</th>
	                </tr>
	            </thead>
	            <tbody id="session-mirror-videos-tbody"></tbody>
            </table><a href="#" id="session-mirror-media-player-link" style="display:none;" target="_blank"></a>';

        $this->video_pagination();
        $this->video_player_modal();
    }

    public function settings_form($data = array()) {
        echo '<form action="' . admin_url('admin.php?page=session-mirror-settings') . '" method="post" id="session-mirror-settings-form-f">';
        echo wp_nonce_field('session-mirror-settings', '_wpnonce_session-mirror-settings');
        echo '<table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row"><label for="api_key">' . __('API Key', SESSION_MIRROR_PLUGIN_LANG_DOMAIN)  . '</label></th>
                    <td><input name="session_mirror_api_key" type="password" id="api_key" value="' . (isset($data['api_key']) ? $data['api_key'] : '') . '" class="regular-text"></td>
                    <td>
                    ' . __('If you do not have an account, you can register simply', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . ' 
                    <a href="https://dashboard.sessionmirror.com/auth/register" target="_blank">' . __('Create User', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</a>.
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="secret_key">' . __('Secret Key', SESSION_MIRROR_PLUGIN_LANG_DOMAIN)  . '</label></th>
                    <td><input name="session_mirror_secret" type="password" id="secret_key" value="' . (isset($data['secret']) ? $data['secret'] : '') . '" class="regular-text"></td>
                    <td>
                    ' . __('You can create Api key and Secret key from the', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . ' 
                    <a href="https://dashboard.sessionmirror.com/user/settings" target="_blank">' . __('Settings Page', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</a>.
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="session_mirror_site">' . __('Site Domain', SESSION_MIRROR_PLUGIN_LANG_DOMAIN)  . '</label></th>
                    <td><input name="session_mirror_site" type="text" id="session_mirror_site" value="' . (isset($data['domain']) ? $data['domain'] : '') . '" class="regular-text"></td>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row"><label for="session_mirror_site_status">' . __('Site Status', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</label></th>
                    <td>
                        <select name="session_mirror_site_status" id="session_mirror_site_status">
	                        <option value="ACTIVE" ' . ((isset($data['status']) && $data['status'] === 'ACTIVE') ? 'selected="selected"' : '') . '>' . __('Active', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) .'</option>
	                        <option value="PASSIVE" ' . ((isset($data['status']) && $data['status'] === 'PASSIVE') ? 'selected="selected"' : '') . '>' . __('Passive', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) .'</option>
	                    </select>
	                    <small>' . __('If you set as Passive, we can not recording video.', SESSION_MIRROR_PLUGIN_LANG_DOMAIN).  '</small>
	                </td>
	                <td></td>
                </tr>
                <tr>
                    <th scope="row"><label for="session_mirror_media_player_type">' . __('Media Player Type', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</label></th>
                    <td>
                        <select name="session_mirror_media_player_type" id="session_mirror_media_player_type">
	                        <option value="IFRAME" ' . ((isset($data['media_player_type']) && $data['media_player_type'] === 'IFRAME') ? 'selected="selected"' : '') . '>' . __('Iframe', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) .'</option>
	                        <option value="LINK" ' . ((isset($data['media_player_type']) && $data['media_player_type'] === 'LINK') ? 'selected="selected"' : '') . '>' . __('Link', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) .'</option>
	                    </select>
	                    <br>
	                    <small>' . __('Iframe: Videos\'ll play on your wordpress dashboard', SESSION_MIRROR_PLUGIN_LANG_DOMAIN).  '</small>
	                    <br/>
	                    <small>' . __('Link: Videos\'ll play on dashboard.sessionmirror.com', SESSION_MIRROR_PLUGIN_LANG_DOMAIN).  '</small>
                    </td>
                    <td></td>
                </tr>
            </tbody>
            </table>';

        submit_button();

        echo '<a class="button button-danger" href="' . admin_url('admin.php?page=session-mirror-settings&amp;reset-settings=true'). '">' . __('Reset', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</a>';

        echo '</form>';
    }

    public function please_log_in_first_notice() {
        echo '<div class="notice notice-error settings-error"> 
                    <p><strong>' . sprintf(__('Please set your Api key and Secret key from the %s settings page %s', SESSION_MIRROR_PLUGIN_LANG_DOMAIN), '<a href="' . admin_url('admin.php?page=session-mirror-settings') . '">', '</a>') . '</strong></p>
              </div>';
    }

    public function settings_saved_successfully_notice() {
        echo '<div class="notice notice-success"> 
                    <p><strong>' . __('Settings saved successfully', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</strong></p>
              </div>';
    }

    public function settings_could_not_be_saved_notice() {
        echo '<div class="notice notice-error"> 
                    <p><strong>' . __('Settings could not be saved, please check your inputs', SESSION_MIRROR_PLUGIN_LANG_DOMAIN) . '</strong></p>
              </div>';
    }

}
