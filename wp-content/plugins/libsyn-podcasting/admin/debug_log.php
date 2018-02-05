<?php
$plugin = new Libsyn\Service();
$sanitize = new Libsyn\Service\Sanitize();
$current_user_id = $plugin->getCurrentUserId();
$api = $plugin->retrieveApiById($current_user_id);
$render = true;
$error = false;
$libsyn_text_dom = $plugin->getTextDom();

/* Handle saved api */
if ($api instanceof \Libsyn\Api && !$api->isRefreshExpired()){
	$refreshApi = $api->refreshToken(); 
	if($refreshApi) { //successfully refreshed
		$api = $plugin->retrieveApiById($current_user_id);
	} else { //in case of a api call error...
		$handleApi = true; 
		$clientId = (!isset($clientId))?$api->getClientId():$clientId; 
		$clientSecret = (!isset($clientSecret))?$api->getClientSecret():$clientSecret; 
		$api = false;
		if(isset($showSelect)) unset($showSelect);
	}
}

if(isset($_POST['msg'])) $msg = $_POST['msg'];
if(isset($_POST['error'])) $error = ($_POST['error']==='true')?true:false;

/* Check Logger File Path */
if($plugin->logger){
	if(!empty($plugin->logger->logFilePath)) {
		if(is_writable($plugin->logger->logFilePath)){
			//looks good nothing.
		} else {
			$error = true;
			$msg = 'The Log file at <strong>'.$plugin->loggerFP.'</strong> is not writable by the server.  Please contact your server administrator and modify this files\' permission.';
		}
	} else {
		$error = true;
		$msg = 'The log file cannot be found.  This may be caused by the server being unable to create the log file.  Please contact your server administrator to support plugin logging.';
	}
} else {
	$error = true;
	$msg = 'The plugin logger is not currently running.  If you would like it to run please contact your server administrator and set the file permission to writable for the libsyn-podcasting directory.';
}

/* Handle API Creation/Update*/
if((!$api)||($api->isRefreshExpired())) { //does not have $api setup yet in WP
	$render = false;
}

/* Export list of installed plugins */
$all_plugins = get_plugins();
if(is_array($all_plugins)) {
	if($plugin->logger) $plugin->logger->info("Plugins:\tGenerating list of installed plugins.");
	foreach($all_plugins as $pluginName => $pluginInfo){
		if(!empty($pluginName)) {
			if($plugin->logger) $plugin->logger->info("Plugins:\t".$pluginName."\n\t\tName:\t".$pluginInfo['Name']."\n\t\tURI:\t".$pluginInfo['PluginURI']."\n\t\tVersion:\t".$pluginInfo['Version']);
		}
	}
}

/* Set Notifications */
if(isset($msg)) $plugin->createNotification($msg, $error);
global $libsyn_notifications;
do_action('libsyn_notifications');
?>


<?php wp_enqueue_script( 'jquery-ui-dialog', array('jquery-ui')); ?>
<?php wp_enqueue_style( 'wp-jquery-ui-dialog'); ?>
<?php wp_enqueue_script('jquery_validate', plugins_url(LIBSYN_DIR.'/lib/js/jquery.validate.min.js'), array('jquery')); ?>
<?php wp_enqueue_script('libsyn_meta_validation', plugins_url(LIBSYN_DIR.'/lib/js/meta_form.js')); ?>
<?php wp_enqueue_style( 'metaBoxes', plugins_url(LIBSYN_DIR.'/lib/css/libsyn_meta_boxes.css' )); ?>
<?php wp_enqueue_style( 'metaForm', plugins_url(LIBSYN_DIR.'/lib/css/libsyn_meta_form.css' )); ?>
<?php wp_enqueue_script( 'colorPicker', plugins_url(LIBSYN_DIR.'/lib/js/jquery.colorpicker.js' )); ?>
<?php wp_enqueue_style( 'colorPickerStyle', plugins_url(LIBSYN_DIR.'/lib/css/jquery.colorpicker.css' )); ?>

	<style media="screen" type="text/css">
	.code { font-family:'Courier New', Courier, monospace; }
	.code-bold {
		font-family:'Courier New', Courier, monospace;
		font-weight: bold;
	}
	</style>

	<div class="wrap">
	  <h2><?php _e("Error Log", $libsyn_text_dom); ?><span style="float:right"><a href="http://www.libsyn.com/"><img src="<?php _e(plugins_url( LIBSYN_DIR . '/lib/images/libsyn_dark-small.png'), $libsyn_text_dom); ?>" title="Libsyn Podcasting" height="28px"></a></span></h2>
	  <!-- Content Area -->
	<div id="poststuff">
		<form name="<?php echo LIBSYN_NS . "form" ?>" id="<?php echo LIBSYN_NS . "form" ?>" method="post" action="javascript:void(0);">
			<div id="post-body-content">
				<div class="stuffbox" style="width:93.5%">
					<h3 class="hndle"><span><?php _e("Download Error Logs", $libsyn_text_dom); ?></span></h3>
					<div class="inside" style="margin: 15px;">
						<div style="height: 96px;padding-top:24px;" id="libsyn-download-log-containter">
							<div style="line-height:2.4em;">
								<div style="float: left;width:45%;"><strong>If you are having trouble with the plugin please download the log file to submit to our developers.</strong>
								</div>
								<div style="float: left; width: 25%;">
									<button type="button" id="libsyn-download-log-button" class="button libsyn-dashicions-download">
										Download Log
									</button>
								</div>
							</div>
							<div style="line-height:2.4em;" id="libsyn-download-phpinfo-div">
								<div style="float: left;width:45%;"><strong>Optionally, you may also submit your PHP server information running Wordpress.</strong>
								</div>
								<div style="float: left; width: 25%;">
									<button type="button" id="libsyn-download-phpinfo-button">
										Download Php Information
									</button>
								</div>
							</div>
						</div>
						<div style="height:96px;padding-top:24px;display:none;" id="libsyn-no-debug-log-message">
							<p>Your web host does not support writing to the debug log file.  If you are sending this to Libsyn support, please list your currently installed plugins along with any questions.</p>
						</div>
					</div>
				</div>
				<div class="stuffbox" id="libsyn-phpinfo-box" style="width:93.5%;display:none;">
					<h3 class="hndle"><span><?php _e("PHP Information", $libsyn_text_dom); ?></span></h3>
					<div class="inside" style="margin: 15px;" id="libsyn-phpinfo">
					</div>
				</div>
			</div>
		</form>
	</div>
	<script type="text/javascript">
		(function($){
			$(document).ready(function(){
				//check ajax
				var check_ajax_url = "<?php echo $sanitize->text($plugin->admin_url() . '?action=libsyn_check_url&libsyn_check_url=1'); ?>";
				var ajax_error_message = "<?php __('Something went wrong when trying to load your site\'s base url.
						Please make sure your "Site Address (URL)" in Wordpress settings is correct.', LIBSYN_DIR); ?>";		
				$.getJSON( check_ajax_url).done(function(json) {
					if(json){
						//success do nothing
					} else {
						//redirect to error out
						var ajax_error_url = "<?php echo $plugin->admin_url('admin.php').'?page='.LIBSYN_DIR.'/admin/debug_log.php&error=true&msg='; ?>" + ajax_error_message;
						if (typeof window.top.location.href == "string") window.top.location.href = ajax_error_url;
								else if(typeof document.location.href == "string") document.location.href = ajax_error_url;
									else if(typeof window.location.href == "string") window.location.href = ajax_error_url;
										else alert("Unknown javascript error 1028.  Please report this error to support@libsyn.com and help us improve this plugin!");
					}
				}).fail(function(jqxhr, textStatus, error) {
						//redirect to error out
						var ajax_error_url = "<?php echo $plugin->admin_url('admin.php').'?page='.LIBSYN_DIR.'/admin/debug_log.php&error=true&msg='; ?>" + ajax_error_message;
						if (typeof window.top.location.href == "string") window.top.location.href = ajax_error_url;
								else if(typeof document.location.href == "string") document.location.href = ajax_error_url;
									else if(typeof window.location.href == "string") window.location.href = ajax_error_url;
										else alert("Unknown javascript error 1029.  Please report this error to support@libsyn.com and help us improve this plugin!");
				});
			});
		})(jQuery);
	</script>
	<script type="text/javascript">
		(function($){
			$(document).ready(function(){
				//handle download of log file
				var libsynPluginLoggerFilePath = '<?php echo ($plugin->logger)?$sanitize->text(plugins_url( LIBSYN_DIR . '/admin/lib/' . $libsyn_text_dom . '.log')):''; ?>';
				var libsynPhpinfo = "<?php echo $sanitize->text($plugin->admin_url() . '?action=libsyn_phpinfo&libsyn_phpinfo=1'); ?>";
				// $( "#libsyn-phpinfo" ).load( libsynPhpinfo, function( response, status, xhr ) {
					// if ( status == "error" ) {
						// var msg = "Sorry but there was an error: ";
						// $( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
					// }
				// });
				$("#libsyn-download-phpinfo-button").button({
					icons: {
						primary: "libsyn-dashicions-download-phpinfo"
					}
				});
				if(libsynPluginLoggerFilePath.length > 0){
					$("#libsyn-download-log-button").click(function(){
						// window.open(libsynPluginLoggerFilePath);
						var download_log_anchor = document.createElement('a');
						if(typeof download_log_anchor.download === 'string') {
							download_log_anchor.href = libsynPluginLoggerFilePath;
							download_log_anchor.setAttribute('download', '<?php _e($libsyn_text_dom . '.log'); ?>');
							document.body.appendChild(download_log_anchor);
							download_log_anchor.click();
							document.body.removeChild(download_log_anchor);
						} else {
							window.open(libsynPluginLoggerFilePath);
						}
					});
				} else {
					$("#libsyn-download-log-containter").hide('fast');
					$("#libsyn-no-debug-log-message").fadeIn('fast');
				}
				if(libsynPhpinfo.length > 0){
					$("#libsyn-download-phpinfo-button").click(function(){
						// window.open(libsynPhpinfo);
						// var libsyn_pdf_text = $("#libsyn-phpinfo").text();
						var download_phinfo_anchor = document.createElement('a');
						if(typeof download_phinfo_anchor.download === 'string') {
							download_phinfo_anchor.href = libsynPhpinfo;
							// download_phinfo_anchor.href = 'data:attachment/html,' + encodeURI(libsyn_pdf_text);
							// download_phinfo_anchor.target = '_blank';
							download_phinfo_anchor.setAttribute('download', '<?php _e($libsyn_text_dom . '_phpinfo.html'); ?>');
							document.body.appendChild(download_phinfo_anchor);
							download_phinfo_anchor.click();
							document.body.removeChild(download_phinfo_anchor);
						} else {
							window.open(libsynPhpinfo);
						}
					});
				} else {
					$("#libsyn-download-phpinfo-button").hide('fast');
					$("#libsyn-download-phpinfo-div").hide('fast');
				}
			});
		})(jQuery);
	</script>