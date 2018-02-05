<?php
namespace Libsyn;

class Utilities extends \Libsyn{
	
	/**
	 * Handles WP callback to send variable to trigger AJAX response.
	 * 
	 * @param <array> $vars 
	 * 
	 * @return <array>
	 */
	public static function plugin_add_trigger_libsyn_check_ajax($vars) {
		$vars[] = 'libsyn_check_url';
		return $vars;
	}
	
	/**
	 * Handles WP callback to send variable to trigger AJAX response.
	 * 
	 * @param <array> $vars 
	 * 
	 * @return <array>
	 */
	public static function plugin_add_trigger_libsyn_phpinfo($vars) {
		$vars[] = 'libsyn_phpinfo';
		return $vars;
	}
	
	/**
	 * Handles WP callback to save ajax settings
	 * 
	 * @param <array> $vars 
	 * 
	 * @return <array>
	 */
	public static function plugin_add_trigger_libsyn_oauth_settings($vars) {
		$vars[] = 'libsyn_oauth_settings';
		return $vars;
	}
	
	/**
	 * Handles WP callback to clear outh settings
	 * 
	 * @param <array> $vars 
	 * 
	 * @return <array>
	 */
	public static function plugin_add_trigger_libsyn_update_oauth_settings($vars) {
		$vars[] = 'libsyn_update_oauth_settings';
		return $vars;
	}
	
	/**
	 * Renders a simple ajax page to check against and test the ajax urls
	 * 
	 * 
	 * @return <mixed>
	 */
	public static function checkAjax() {
		$error = true;
		$checkUrl  = self::getCurrentPageUrl();
		parse_str($checkUrl, $urlParams);
		if(intval($urlParams['libsyn_check_url']) === 1) {
			$error = false;
			$json = true; //TODO: may need to do a check here later.
			//set output
			header('Content-Type: application/json');
			if(!$error) echo json_encode($json);
				else echo json_encode(array());
			exit;
		}
	}
	
	/**
	 * Renders a phpinfo dump and returns json
	 * 
	 * 
	 * @return <mixed>
	 */
	public static function getPhpinfo() {
		$error = true;
		$checkUrl  = self::getCurrentPageUrl();
		parse_str($checkUrl, $urlParams);
		if(intval($urlParams['libsyn_phpinfo']) === 1) {
			$data = self::parse_phpinfo();
			
			// header('Content-Type: application/json');
			header('Content-Type: text/html');
			// if(!empty($data)) echo self::arrayToCsv($data);
			if(!empty($data)) {
				echo "<h3>PHP Server Information</h3>\n" . self::prettyPrintArray($data);
			} else echo "";
			exit;
		}
	}
		
	function prettyPrintArray($arr){
		$retStr = '<ul>';
		if (is_array($arr)){
			foreach ($arr as $key=>$val){
				if (is_array($val)){
					$retStr .= '<li>' . $key . ' => ' . self::prettyPrintArray($val) . '</li>';
				}else{
					$retStr .= '<li>' . $key . ' => ' . $val . '</li>';
				}
			}
		}
		$retStr .= '</ul>';
		return $retStr;
	}
	
    /**
     * Parses phpinfo into usable information format
     * 
     * 
     * @return <type>
     */
	function parse_phpinfo() {
		ob_start(); phpinfo(INFO_MODULES); $s = ob_get_contents(); ob_end_clean();
		$s = strip_tags($s, '<h2><th><td>');
		$s = preg_replace('/<th[^>]*>([^<]+)<\/th>/', '<info>\1</info>', $s);
		$s = preg_replace('/<td[^>]*>([^<]+)<\/td>/', '<info>\1</info>', $s);
		$t = preg_split('/(<h2[^>]*>[^<]+<\/h2>)/', $s, -1, PREG_SPLIT_DELIM_CAPTURE);
		$r = array(); $count = count($t);
		$p1 = '<info>([^<]+)<\/info>';
		$p2 = '/'.$p1.'\s*'.$p1.'\s*'.$p1.'/';
		$p3 = '/'.$p1.'\s*'.$p1.'/';
		for ($i = 1; $i < $count; $i++) {
			if (preg_match('/<h2[^>]*>([^<]+)<\/h2>/', $t[$i], $matchs)) {
				$name = trim($matchs[1]);
				$vals = explode("\n", $t[$i + 1]);
				foreach ($vals AS $val) {
					if (preg_match($p2, $val, $matchs)) { // 3cols
						$r[$name][trim($matchs[1])] = array(trim($matchs[2]), trim($matchs[3]));
					} elseif (preg_match($p3, $val, $matchs)) { // 2cols
						$r[$name][trim($matchs[1])] = trim($matchs[2]);
					}
				}
			}
		}
		return $r;
	}
	
	/**
	 * Saves Settings form oauth settings for dialog
	 * 
	 * 
	 * @return <mixed>
	 */
	public static function saveOauthSettings() {
		$error = true;
		$checkUrl  = self::getCurrentPageUrl();
		parse_str($checkUrl, $urlParams);
		if(intval($urlParams['libsyn_oauth_settings']) === 1) {
			$error = false;
			$json = true; //TODO: may need to do a check here later.
			$sanitize = new \Libsyn\Service\Sanitize();		
			
			if(isset($_POST['clientId'])&&isset($_POST['clientSecret'])) { 
				update_option('libsyn-podcasting-client', array('id' => $sanitize->clientId($_POST['clientId']), 'secret' => $sanitize->clientSecret($_POST['clientSecret']))); 
				$clientId = $_POST['clientId']; 
				$clientSecret = $_POST['clientSecret'];
			}
			if(!empty($clientId)) $json = json_encode(array('client_id' => $clientId, 'client_secret' => $clientSecret));
				else $error = true;
			
			//set output
			header('Content-Type: application/json');
			if(!$error) echo json_encode($json);
				else echo json_encode(array());
			exit;
		}
	}
	
	/**
	 * Saves Settings form oauth settings for dialog
	 * 
	 * 
	 * @return <mixed>
	 */
	public static function updateOauthSettings() {
		$error = true;
		$checkUrl  = self::getCurrentPageUrl();
		parse_str($checkUrl, $urlParams);
		if(intval($urlParams['libsyn_update_oauth_settings']) === 1) {
			$error = false;
			$json = true;
			$sanitize = new \Libsyn\Service\Sanitize();
			$json = 'true'; //set generic response to true
			
			if(isset($_GET['client_id']) && isset($_GET['client_secret'])) {
				update_option('libsyn-podcasting-client', array('id' => $sanitize->clientId($_GET['client_id']), 'secret' =>$sanitize->clientSecret($_GET['client_secret']))); 
			} else {
				$error=true;
				$json ='false';
			}
			
			//set output
			header('Content-Type: application/json');
			if(!$error) echo json_encode($json);
				else echo json_encode(array());
			exit;
		}
	}
	
	/**
	 * Clears Settings and deletes table for uninstall
	 * 
	 * 
	 * @return <mixed>
	 */
	public static function uninstallSettings() {
		global $wpdb;
		$option_names = array(
			'libsyn-podcasting-client',
			'libsyn_api_settings'
		);
		$service = new \Libsyn\Service();
		
		foreach($option_names as $option) {
			//delete option
			delete_option( $option );
			// For site options in Multisite
			delete_site_option( $option );
		}
		if($service->hasLogger) $service->logger->info("Utilities:\tremoved settings.");
		
		//drop libsyn db table
		$api_table_name = $service->getApiTableName();
		if(!empty($api_table_name)) {
			try {
				$wpdb->query( "DROP TABLE IF EXISTS ".$api_table_name ); //old without prefix
				$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}".$api_table_name );				
			} catch(Exception $e) {
				//do nothing
			}
			if($service->hasLogger) $service->logger->info("Utilities:\tdropped tables.");
		}
	}
	
    /**
     * Simple function to check if a string is Json
     * 
     * @param <string> $json_string 
     * 
     * @return <bool>
     */
	public function isJson($json_string) {
		return (!empty($json_string) && (is_string($json_string) && (is_object(json_decode($json_string)) || is_array(json_decode($string))))) ? true : false;
	}
	
	/**
	 * Clears Settings and deletes table for uninstall
	 * 
	 * 
	 * @return <mixed>
	 */
	public static function deactivateSettings() {
		global $wpdb;
		$option_names = array(
			'libsyn-podcasting-client',
			'libsyn_api_settings'
		);
		$service = new \Libsyn\Service();
		
		foreach($option_names as $option) {
			//delete option
			delete_option( $option );
			// For site options in Multisite
			delete_site_option( $option );
		}
		if($service->hasLogger) $service->logger->info("Utilities:\tremoved settings.");

		//drop libsyn db table
		$api_table_name = $service->getApiTableName();
		if(!empty($api_table_name)) {
			try {
				$wpdb->query( "DROP TABLE IF EXISTS ".$api_table_name ); //old without prefix
				$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}".$api_table_name );							
			} catch(Exception $e) {
				//do nothing
			}
			if($service->hasLogger) $service->logger->info("Utilities:\tdropped tables.");
		}
	}

	/**
	 * Gets the current page url
	 * @return <string>
	 */
	public static function getCurrentPageUrl() {
		global $wp;
		return add_query_arg( $_SERVER['QUERY_STRING'], '', home_url( $wp->request ) );
	}
	
	/**
	 * function will chmod dirs and files recursively
	 * @param type $start_dir 
	 * @param type $debug (set false if you don't want the function to echo)
	 */
	public static function chmod_recursive($start_dir, $debug = false) {
		$dir_perms = 0755;
		$file_perms = 0644;
		$str = "";
		$files = array();
		if (is_dir($start_dir)) {
			$fh = opendir($start_dir);
			while (($file = readdir($fh)) !== false) {
				// skip hidden files and dirs and recursing if necessary
				if (strpos($file, '.')=== 0) continue;
				$filepath = $start_dir . '/' . $file;
				if ( is_dir($filepath) ) {
					@chmod($filepath, $dir_perms);
					self::chmod_recursive($filepath);
				} else {
					@chmod($filepath, $file_perms);
				}
			}
			closedir($fh);
		}
		if ($debug) {
			echo $str;
		}
	}
}

?>