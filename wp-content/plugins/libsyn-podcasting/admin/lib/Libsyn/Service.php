<?php
namespace Libsyn;

class Service extends \Libsyn {
	
	protected $args;
	
	public static $instance;
	
	public function __construct() {
		global $wpdb;
		global $wp_version;
		parent::getVars();
		self::$instance = $this;
		$this->args = array(
			'timeout'     => 30,
			'redirection' => 5,
			'httpversion' => '1.1',
			'user-agent'  => 'WordPress/' . $wp_version . '; ' . get_bloginfo( 'url' ),
			'blocking'    => true,
			'headers'     =>  array (
				'date' => date("D j M Y H:i:s T", $this->wp_time),
				'x-powered-by' => $this->plugin_name,
				'x-server' => $this->plugin_version,
				'expires' => date("D j M Y H:i:s T", strtotime("+3 hours", $this->wp_time)),
				'vary' => 'Accept-Encoding',
				'connection' => 'close',
				'accept' => 'application/json',
				'content-type' => 'application/json',
			),
			'cookies'     => array(),
			'body'        => null,
			'compress'    => false,
			'decompress'  => true,
			'sslverify'   => true,
			'stream'      => false,
		);
		/* Testing..
		add_action('http_api_curl', function( $handle ){
			//Don't verify SSL certs
			curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($handle, CURLOPT_SSLVERSION, 1);
		}, 10);
		*/
	}
	
    /**
     * Runs a GET to /post collection endpoint
     * 
     * @param <mixed> $urlParamsObj 
     * 
     * @return <object>
     */
	public function getPosts( $urlParamsObj ) {
		if(!is_array($urlParamsObj)) { //handles objects too
			$urlParams = array();
			foreach($urlParamsObj as $key => $val) $urlParams[$key] = $val;
		} else { $urlParams = $urlParamsObj; }
		$url = $this->api_base_uri."/post?" . http_build_query($urlParams);
		return (object) wp_remote_get( $url, $this->args );
	}
	
    /**
     * Runs a GET to /post/$id entity endpoint
     * 
     * @param <Libsyn\Api> $api 
     * @param <array> $urlParams 
     * 
     * @return <mixed>
     */
	public function getPost( \Libsyn\Api $api, $urlParams=array() ) {
		$url = $this->api_base_uri."/post?" . http_build_query($urlParams);
		if($api instanceof Libsyn\Api) {
			return (object) wp_remote_get( $url, $this->args );
		} else {
			if($this->hasLogger) $this->logger->error("Service:\tgetPost:\tapi not instance of Libsyn\Api.");
			return false;
		}
	}
	
    /**
     * Runs a generic GET request
     * 
     * @param <string> $base_url 
     * @param <array> $urlParams 
     * 
     * @return <mixed>
     */
	public function getGeneric( $base_url, $urlParams=array() ) {
		//Sanitize Data
		$sanitize = new \Libsyn\Service\Sanitize();
		$sanitized_url = $sanitize->url_raw($base_url);
		if(!empty($sanitized_url)) {
			$url = $sanitize->url_raw($base_url) . "?" . http_build_query($urlParams);
		} else {
			if($this->hasLogger) $this->logger->error("Service:\tgetGeneric:\tbase_url empty.");
			return false;
		}
		return (object) wp_remote_get( $url, $this->args );
	}
	
    /**
     * Runs a GET to /post entity endpoint
     * 
     * @param <Libsyn\Api> $api 
     * @param <array> $urlParams 
     * 
     * @return <mixed>
     */
	public function getEpisodes( $urlParams=array() ) {
		if(isset($urlParams['show_id'])&&!empty($urlParams['show_id'])) {
			$url = $this->api_base_uri."/post?" . http_build_query($urlParams);
		}
		$obj =  (object) wp_remote_get( $url, $this->args );
		if($this->checkResponse($obj)) {
			$response = json_decode($obj->body);
			if($response) return $response;
		} else return false;
	}
	
    /**
     * Runs a GET to /post entity endpoint
     * 
     * @param <Libsyn\Api> $api 
     * @param <array> $urlParams 
     * 
     * @return <mixed>
     */
	public function getEpisode( $urlParams=array() ) {
		if(isset($urlParams['show_id'])&&!empty($urlParams['show_id']) && isset($urlParams['item_id'])&&!empty($urlParams['item_id'])) {
			$itemId = $urlParams['item_id'];
			unset($urlParams['item_id']);
			$url = $this->api_base_uri."/post/$itemId?" . http_build_query($urlParams);
		}

		$obj =  (object) wp_remote_get( $url, $this->args );
		if($this->checkResponse($obj)) {
			$response = json_decode($obj->body);
			if($response) return $response;
		} else return false;
	}
	
    /**
     * Runs a POST to /post endpoint
     * 
     * @param <Libsyn\Api> $api 
     * @param <array> $item
     * 
     * @return <mixed>
     */
	public function postPost( \Libsyn\Api $api, $item ) {
		if($api instanceof \Libsyn\Api) {
			if(isset($item['item_id'])&&!empty($item['item_id'])) $url = $this->api_base_uri."/post/".$item['item_id'];
				else $url = $this->api_base_uri."/post";
			$this->args['headers']['Authorization'] = "Bearer ".$api->getAccessToken();

			$payload = '';
			$boundary = wp_generate_password( 24 );
			$this->args['headers']['content-type'] = "multipart/form-data; boundary=".$boundary;
			// First, add the standard POST fields:
			foreach ( $item as $name => $value ) {
				//handle sub arrays
				if(is_array($value)) {
					foreach($value as $key => $val) {
						if(is_array($val)) { //check 2nd level array (this is all that is needed is two levels)
							foreach ($val as $subKey => $subVal) {
								$payload .= '--' . $boundary;
								$payload .= "\r\n";
								$payload .= 'Content-Disposition: form-data; name="' . $name .'['.$key.']' .'['.$subKey.']"' . "\r\n\r\n";
								$payload .= $subVal;
								$payload .= "\r\n";
							}
						} else {						
							$payload .= '--' . $boundary;
							$payload .= "\r\n";
							$payload .= 'Content-Disposition: form-data; name="' . $name .'['.$key.']"' . "\r\n\r\n";
							$payload .= $val;
							$payload .= "\r\n";
						}
					}
				} else {
					$payload .= '--' . $boundary;
					$payload .= "\r\n";
					$payload .= 'Content-Disposition: form-data; name="' . $name .'"' . "\r\n\r\n";
					$payload .= $value;
					$payload .= "\r\n";
				}
			}
			$payload .= '--' . $boundary . '--';
			$this->args['body'] = $payload;
			$obj =  (object) wp_remote_post( $url, $this->args );
			if($this->checkResponse($obj)) {
				$response = json_decode($obj->body);
				if($response->{'status'}==='success') return $response->{'post'};
					else return false;
			} else return false;
		} else return false;
	}
	
    /**
     * Runs a GET on /shows endpoint
     * 
     * @param <Libsyn\Api> $api 
     * @param <array> $urlParams 
     * 
     * @return <mixed>
     */
	public function getShows( \Libsyn\Api $api, $urlParams=array() ) {
		$params = (!empty($urlParams))?"?".http_build_query($urlParams):"";
		$url = $this->api_base_uri."/user-shows" . $params;
		if($api instanceof \Libsyn\Api) {
			$this->args['headers']['Authorization'] = "Bearer ".$api->getAccessToken();
			$obj =  (object) wp_remote_get( $url, $this->args );
			if($this->checkResponse($obj)) return json_decode($obj->body)->_embedded;
				else return false;
		}
		else return false;
	}
	
    /**
     * Runs a GET on /wordpress endpoint
     * Also sets up redirect on WP
	 *
     * @param <Libsyn\Api> $api 
     * @param <array> $urlParams 
     * 
     * @return <mixed>
     */
	public function feedImport( \Libsyn\Api $api, $urlParams=array() ) {
		$urlParams = array('show_id' => $api->getShowId(), 'feed_url' => $api->getFeedRedirectUrl());
		$params = (!empty($urlParams))?"?".http_build_query($urlParams):"";
		$url = $this->api_base_uri."/wordpress" . $params;
		if($api instanceof \Libsyn\Api) {
			$this->args['headers']['Authorization'] = "Bearer ".$api->getAccessToken();
			$obj =  (object) wp_remote_get( $url, $this->args );
			if($this->checkResponse($obj)) return json_decode($obj->body)->_embedded;
				else return false;
		}
		else return false;
	}
	
    /**
     * Runs a GET on /ftp-unreleased endpoint
     * 
     * @param <Libsyn\Api> $api 
     * @param <array> $urlParams 
     * 
     * @return <mixed>
     */
	public function getFtpUnreleased( \Libsyn\Api $api, $urlParams=array() ) {
		if($api instanceof \Libsyn\Api) {
			if(!isset($urlParams['show_id'])) $urlParams['show_id'] = $api->getShowId();
			$params = "?".http_build_query($urlParams);
			$url = $this->api_base_uri."/ftp-unreleased" . $params;
			$this->args['headers']['Authorization'] = "Bearer ".$api->getAccessToken();
			$obj =  (object) wp_remote_get( $url, $this->args );
			if($this->checkResponse($obj)) return json_decode($obj->body)->_embedded;
				else return false;
		} else return false;
	}
	
    /**
     * Runs a GET on /categories endpoint
     * 
     * @param <Libsyn\Api> $api 
     * @param <array> $urlParams 
     * 
     * @return <mixed>
     */
	public function getCategories ( \Libsyn\Api $api, $urlParams=array() ) {
		if($api instanceof \Libsyn\Api) {
			if(!isset($urlParams['show_id'])) $urlParams['show_id'] = $api->getShowId();
			$params = "?".http_build_query($urlParams);
			$url = $this->api_base_uri."/categories" . $params;
			$this->args['headers']['Authorization'] = "Bearer ".$api->getAccessToken();
			$obj =  (object) wp_remote_get( $url, $this->args );
			if($this->checkResponse($obj)) return json_decode($obj->body)->_embedded;
				else return false;
		} else return false;
	}
	
    /**
     * Runs a GET on /destinations endpoint
     * 
     * @param <Libsyn\Api> $api 
     * @param <array> $urlParams 
     * 
     * @return <mixed>
     */
	public function getDestinations( \Libsyn\Api $api, $urlParams=array() ) {
		if($api instanceof \Libsyn\Api) {
			if(!isset($urlParams['show_id'])) $urlParams['show_id'] = $api->getShowId();
			$params = "?".http_build_query($urlParams);
			$url = $this->api_base_uri."/destinations/"  . $api->getShowId() . $params;
			$this->args['headers']['Authorization'] = "Bearer ".$api->getAccessToken();
			$obj = (object) wp_remote_get( $url, $this->args );
			if($this->checkResponse($obj)&&isset(json_decode($obj->body)->_embedded)) return json_decode($obj->body)->_embedded;
				else return false;
		} else return false;
	}
	
    /**
     * Handles changes made to Libsyn-WP api settings
     * 
     * @param <Libsyn\Api> $api
     * 
     * @return <Libsyn\Api>
     */
	public function updateSettings( \Libsyn\Api $api ) {
		if($api instanceof \Libsyn\Api) {
			$api->save();
		}
		return $api;
	}
	
    /**
     * Remove Libsyn-WP api settings
     * 
     * @param <Libsyn\Api> $api 
     * 
     * @return <type>
     */
	public function removeApiSettings( \Libsyn\Api $api ) {
		global $wpdb;
		$wpdb->update(
			$this->getApiTableName(), 
			array(
				'is_active' => 0,
			),
			array(
				'plugin_api_id' => $api->getPluginApiId(),
			)
		);		
	}
	
    /**
     * Get a iFrame output for the Libsyn-WP settings panel
     * 
     * @param <mixed> $clientId 
     * @param <string> $redirectUri 
     * 
     * @return <string>
     */
	public function oauthAuthorize( $clientId=null, $redirectUri='' ) {
		if(!empty($clientId) && !empty($redirectUri)) {
			$urlParams = array(
				'client_id' => $clientId
				,'redirect_uri' => str_replace('%2F', '/', urldecode($redirectUri))
				,'response_type' => 'code'
				,'state' => 'xyz'
				,'auth_namespace' => 'true'
			);
			$url = $this->api_base_uri."/oauth/authorize?" . http_build_query($urlParams);
			return "<iframe id=\"oauthBox\" src=\"".$url."&authorized=true"."\" width=\"600\" height=\"450\"></iframe>";
		} else {
			return "<iframe id=\"oauthBox\" width=\"600\" height=\"450\"><html><head></head><body><h3>Either the client ID or Wordpress Site URL are incorrect.  Please check your settings and try again.</h3></body></html></iframe>";
		}
		return "<iframe id=\"oauthBox\" width=\"600\" height=\"450\"><html><head></head><body><h3>An unknown error has occurred,  please check your settings and try again.</h3></body></html></iframe>";
	}
	
    /**
     * Get a the API URL to load authentication.
     * 
     * @param <mixed> $clientId 
     * @param <string> $redirectUri 
     * 
     * @return <string>
     */
	public function getAuthorizeUrl( $clientId=null, $redirectUri='' ) {
		$urlParams = array(
			'client_id' => $clientId
			,'redirect_uri' => str_replace('%2F', '/', urldecode($redirectUri))
			,'response_type' => 'code'
			,'state' => 'xyz'
			,'auth_namespace' => 'true'
		);
		return $this->api_base_uri."/oauth/authorize?" . http_build_query($urlParams);
	}

    /**
     * Do a new auth bearer request
     * 
     * @param <mixed> $clientId 
     * @param <mixed> $secret 
     * @param <string> $code 
     * @param <string> $redirectUri 
     * 
     * @return <mixed>
     */
	public function requestBearer( $clientId=null, $secret=null, $code, $redirectUri='') {
		$redirectUriParts = wp_parse_url($redirectUri);
		parse_str($redirectUriParts['query']);
		
		//set params
		$params = array();

		if(!empty($page) && urldecode($redirectUriParts['scheme'].'://'.$redirectUriParts['host'].$redirectUriParts['path'].'?page='.$page) === $this->admin_url('admin.php').'?page='.LIBSYN_DIR.'/admin/settings.php') { //Redirect URI Sanity checks
			//looks good
			$params['redirect_uri'] = $this->admin_url('admin.php').'?page='.LIBSYN_DIR.'/admin/settings.php';
		} else {
			$params['redirect_uri'] = (!empty($page)) ? $redirectUriParts['scheme'].'://'.$redirectUriParts['host'].$redirectUriParts['path'].'?page='.$page : $this->admin_url('admin.php').'?page='.LIBSYN_DIR.'/admin/settings.php';
		}
		if(!empty($clientId)) $params['client_id'] = $clientId;
		if(!empty($secret)) $params['client_secret'] = $secret;
		if(!empty($code)) $params['code'] = $code;
		$params['grant_type'] = 'authorization_code';
		$args = array("method" => "POST") + $this->args;
		$args['body'] = json_encode($params);
		$url = $this->api_base_uri."/oauth";
		if(!is_null($clientId)&&!is_null($secret)) {
			return (object) wp_remote_post( $url, $args );
		} else {
			if(isset($this->logger) && $this->hasLogger) {
				$this->logger->error("Service:\trequestBearer:\tEither client_id or secret is null.");
			}
			return false;
		}
	}
	
	public function checkResponse( $obj ) {
		if(!is_object($obj)) return false;
		if($obj->response['code']!==200) {
			if(isset($this->logger)) {
				if($this->hasLogger) { // log errors
					if ( is_wp_error( $obj ) ) {
						$WPErrrorsList = $obj->get_error_messages();
						if(!empty($WPErrrorsList) && is_array($WPErrrorsList)) {
							$this->logger->error("Service:\tWP_ERROR:\t".implode(" ", $WPErrrorsList));
						}
					}
					if(!empty($obj->response['code'])) 
						$this->logger->error("Service:\tHTTP_STATUS_CODE:\t".$obj->response['code']);
							else $this->logger->error("Service:\tHTTP_STATUS_CODE:\tunknown");
					if(!empty($obj->response['url']))
						$this->logger->error("Service:\turl:\t".$obj->response['url']);
							else $this->logger->error("Service:\turl:\tunknown");
					if(!empty($obj->body))
						$this->logger->error("Service:\tcheckResponse:\tResponse Body:\t".$obj->body);
					if(!empty($obj->response['success']))
						$this->logger->error("Service:\tsuccess:\t".$obj->response['success']);
							elseif(!empty($obj->response['message']))
								$this->logger->error("Service:\tmessage:\t".$obj->response['message']);
									else $this->logger->error("Service:\tsuccess:\tunknown");
					if(!empty($obj->response['status_code']))
						$this->logger->error("Service:\tstatus_code:\t".$obj->response['status_code']);
							elseif(!empty($obj->response['code']))
								$this->logger->error("Service:\tstatus_code:\t".$obj->response['code']);
									else $this->logger->error("Service:\tstatus_code:\tunknown");
					if(!empty($obj->http_response)){
						$objectResponse = $obj->http_response->get_data();
						if(!empty($objectResponse)) {
							$res_data = json_decode($objectResponse);
							if(!empty($res_data->title)) $this->logger->error("Service:\ttitle:\t".$res_data->title);
							if(!empty($res_data->detail)) $this->logger->error("Service:\tdetail:\t".$res_data->detail);
						}
					}
				}
			}
			return false;
		} else {
			return true;
		}
	}
	
	/* DEPRECATED */
    /**
     * Create new Libsyn-WP Api
     * 
     * @param <array> $settings 
     * 
     * @return <Libsyn\Api>
     */
	public function createLibsynApi( array $settings ) {
		global $wpdb;
		/*
		 * We'll set the default character set and collation for this table.
		 * If we don't do this, some characters could end up being converted 
		 * to just ?'s when saved in our table.
		 */
		$charset_collate = '';
		$api_table_name = $this->getApiTableName();

		if ( ! empty( $wpdb->charset ) ) {
		  $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
		}

		if ( ! empty( $wpdb->collate ) ) {
		  $charset_collate .= " COLLATE {$wpdb->collate}";
		}

		$sql = "CREATE TABLE $api_table_name (
		  plugin_api_id mediumint(9) NOT NULL AUTO_INCREMENT,
		  client_id varchar(64) NOT NULL,
		  client_secret varchar(80) NOT NULL,
		  access_token varchar(40) NOT NULL,
		  refresh_token varchar(40) NOT NULL,
		  is_active tinyint(3) DEFAULT 0 NOT NULL,
		  refresh_token_expires DATETIME DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  access_token_expires datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  show_id int(8),
		  feed_redirect_url varchar(510),
		  itunes_subscription_url varchar(510),
		  creation_date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		  last_updated timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  UNIQUE KEY id (plugin_api_id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
		//Sanitize Data
		$sanitize = new \Libsyn\Service\Sanitize();
		
		//insert $settings
		$wpdb->insert( 
			$api_table_name, 
			array(
				
				'client_id' => $sanitize->clientId($settings['client_id']),
				'client_secret' => $sanitize->clientSecret($settings['client_secret']),
				'access_token' => $sanitize->accessToken($settings['access_token']),
				'refresh_token' => $sanitize->refreshToken($settings['refresh_token']),
				'is_active' => 1,
				'refresh_token_expires' => $sanitize->date_format(date("Y-m-d H:i:s", strtotime("+88 days", strtotime(current_time( 'mysql' ))))), 
				'access_token_expires' => $sanitize->date_format(date("Y-m-d H:i:s", strtotime("+28 days", strtotime(current_time( 'mysql' ))))), 
				'creation_date' =>  $sanitize->date_format(current_time( 'mysql' )),
			)
		);
		$lastId = $wpdb->insert_id;
		$data = $wpdb->get_results("SELECT * FROM $api_table_name WHERE plugin_api_id = $lastId AND is_active = 1");
		if($this->hasLogger) $this->logger->info("Service:\tcreateLibsynApi:\tCreating New Libsyn API");
		return new \Libsyn\Api($data[0]);
	}
	
    /**
     * Get Libsyn-WP Api
	 * 
     * NOTE: This is not guaranteed the current api result
	 * this will get the first found if it is not set.
     * 
     * @return <mixed>
     */
	public function getApi() {
		global $wpdb;
		
		$usersmetaTable = $wpdb->get_var("SHOW TABLES LIKE \"{$wpdb->prefix}usermeta\"");
		if(empty($usersmetaTable)) { //Check table name without prefix (could be multisite)
			$prefix_modified = str_replace('__', '_', preg_replace('/\d/', '', $wpdb->prefix));
			$usersmetaTable = $wpdb->get_var("SHOW TABLES LIKE \"{$prefix_modified}usermeta\"");
		}
		
		if(!empty($usersmetaTable)) {
			try {
				$table_name = $wpdb->prefix . $this->getApiTableName();
				$results = $wpdb->get_var("SELECT meta_value FROM {$usersmetaTable} WHERE meta_key LIKE \"%{$table_name}\"");

				if(empty($results)) {
					//could be multisite or other.. get first result if any
					$results = $wpdb->get_var("SELECT meta_value FROM {$usersmetaTable} WHERE meta_key LIKE \"%{$this->getApiTableName()}\"", '');	
				}
				
			} catch (Exception $e) {
				$results = false;
			}
		} else {
			$results = false;
		}
		if(!empty($results)) {
			$isJson = $this->utilities->isJson($results);
			if($isJson) {
				$results = json_decode($results);
			}
			return new \Libsyn\Api ($results);
		}
		return false;
	}
	
    /**
     * Removes Plugin Settings
     * 
     * @param <type> $api 
     * 
     * @return <type>
     */
	public function removeSettings( $api ) {
		if(!empty($api) && $api instanceof \Libsyn\Api) {
			$user_id = $api->getUserId();
			if(!empty($user_id)) {
				$api_table_name = $this->getApiTableName();
				try {
					$utilities = new Utilities();
					$utilities->deactivateSettings();
					if(function_exists('delete_user_option'))
						delete_user_option($user_id, $api_table_name, false);
				} catch(Exception $e) {
					//do nothing
				}
			}
		}
		return false;
	}
	
    /**
     * Create WP notification markup
     * 
     * @param <string> $msg 
     * @param <bool> $error 
     * 
     * @return <string>
     */
	public function createNotification( $msg, $error=false ) {

		if($error) {
			if($this->hasLogger) $this->logger->error("Service:\createNotification:\t".$msg);
			return "<div class=\"error settings-error\" id=\"setting-error\">"
					."<p><strong>".$msg."</strong></p>"
					."</div>";					
		} else {
			if($this->hasLogger) $this->logger->info("Service:\createNotification:\t".$msg);
			return "<div class=\"updated settings-error\" id=\"setting-error-settings_updated\">"
					."<p><strong>".$msg."</strong></p>"
					."</div>";			
		}
	}
	
    /**
     * Simple helper to grab the script code to force a redirect.
     * 
     * @param <string> $url 
     * 
     * @return <string>
     */
	public function redirectUrlScript( $url ) {
		return 
			"<script type=\"text/javascript\">
				if(typeof window.location.assign == 'function') window.location.assign(\"".$url."\");
				else if (typeof window.location == 'object') window.location(\"".$url."\");
				else if (typeof window.location.href == 'string') window.location.href = \"".$url."\";
				else alert('Unknown script error 1021.  To help us improve this plugin, please report this error to support@libsyn.com.');
			</script>";		
	}
	
	
    /**
     * Creates Api object based on settings
     * 
     * @param <array> $settings  
     * 
     * @return <mixed>
     */
	public function createApi( $settings ) {
		if(!empty($settings)) {		
			$api = new Api($settings);
			$api->update($settings);
		}
		
		return false;
	}
	
    /**
     * Gets a instance of this class
     * 
     * 
     * @return <Libsyn\Service>
     */
	public static function getInstance() {
		if(self::$instance === null) {
			self::$instance = new self();
		}
		return self::$instance;
	}
	
    /**
     * WP requires plugin data to be passed for some stuff,
	 * This generates a sudo WP $plugin_data
     * 
     * 
     * @return <array>
     */
	public function getPluginData() {
		return get_plugin_data($this->plugin_base_dir . LIBSYN_DIR.'.php');
	}
	
    /**
     * Checks to see if there is a post edit already created with libsyn-podcasting plugin
	 * If so, then return the post_id of the post with that item.
     * 
     * @param <int> $itemId 
     * 
     * @return <mixed>
     */
	public function checkEditPostDuplicate( $itemId ){
		global $wpdb;
		$sanitize = new \Libsyn\Service\Sanitize();
		try {
			$results = $wpdb->get_results(
				$wpdb->prepare("SELECT post_id FROM {$wpdb->prefix}postmeta WHERE meta_key='libsyn-item-id' AND meta_value='%d'", $sanitize->itemId($itemId))
			);
		} catch (Exception $e) {
			$results = false;
		}
		if(!empty($results)) {
			return array_shift($results);
		}
		return false;
	}
	
}

?>