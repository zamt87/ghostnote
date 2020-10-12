<?php
if ( ! is_admin() ) { die( 'Access denied' ); }

// Check if running PHP 5.3+.
$php_minimum = '5.3';
if ( version_compare( PHP_VERSION, $php_minimum, '<' ) ) { // Server's PHP is insufficient.
	echo '<br>';
	pb_backupbuddy::alert( '<h3>' . __( 'We have a problem...', 'it-l10n-backupbuddy' ) . '</h3><br>' . __( '<span style="font-size:1.5em;font-weight:bold;">Uh oh!</span><br />BackupBuddy Stash Live requires PHP version 5.3 or newer to run. Please upgrade your PHP version or contact your host for details on upgrading.', 'it-l10n-backupbuddy' ) . ' ' . __( 'Current PHP version', 'it-l10n-backupbuddy' ) . ': ' . PHP_VERSION );
	return;
}

// Check for curl.
if ( ! function_exists( 'curl_version' ) ) {
	echo '<br>';
	pb_backupbuddy::alert( '<h3>' . __( 'We have a problem...', 'it-l10n-backupbuddy' ) . '</h3><br>' . __( 'BackupBuddy Stash Live requires the PHP "curl" extension to run. Please install or contact your host to install curl. This is a standard extension and should be available on all hosts.', 'it-l10n-backupbuddy' ) );
	return;
}

// Check if Godaddy Managed WordPress hosting.
if ( defined( 'GD_SYSTEM_PLUGIN_DIR' ) || class_exists( '\\WPaaS\\Plugin' ) ) {
	echo '<br>';
	pb_backupbuddy::disalert( 'godaddy_managed_wp_detected', __( '<span style="font-size:1.5em;font-weight:bold;">GoDaddy Managed WordPress Hosting Detected</span><br><br>GoDaddy\'s Managed WordPress Hosting recently experienced problems resulting in the WordPress cron not working properly resulting in WordPress\' built-in scheduling and automation functionality malfunctioning. <b>GoDaddy has addressed this issue for US-based customers and we believe it to be resolved for those hosted in the USA. Non-US customers should contact GoDaddy support.</b><br><br>However, if you still experience issues and require a partial workaround go to BackupBuddy -> "Settings" page -> "Advanced Settings / Troubleshooting" tab -> Check the box "Force internal cron" -> Scroll down and "Save" the settings.  This may help you be able to make a manual traditional backup though it may be slow and is not guaranteed.', 'it-l10n-backupbuddy' ) );
}


if ( is_network_admin() ) {
	$admin_url = network_admin_url( 'admin.php' );
} else {
	$admin_url = admin_url( 'admin.php' );
}

// No PHP runtime calculated yet. Try to see if test is finished.
if ( 0 == pb_backupbuddy::$options['tested_php_runtime'] ) {
	backupbuddy_core::php_runtime_test_results();
}

$liveDestinationID = false;
foreach( pb_backupbuddy::$options['remote_destinations'] as $destination_id => $destination ) {
	if ( 'live' == $destination['type'] ) {
		$liveDestinationID = $destination_id;
		break;
	}
}

// Handle disconnect.
if ( ( 'disconnect' == pb_backupbuddy::_GET( 'live_action' ) ) && ( false !== $liveDestinationID ) ) { // If disconnecting and not already disconnected.
	$disconnected = false;
	require_once( pb_backupbuddy::plugin_path() . '/destinations/live/live_periodic.php' );
	require_once( pb_backupbuddy::plugin_path() . '/destinations/stash2/class.itx_helper2.php' );
	$destination_settings = backupbuddy_live_periodic::get_destination_settings();

	if ( 'yes' == pb_backupbuddy::_POST( 'disconnect' ) ) {
		pb_backupbuddy::verify_nonce();

		// Check for active Stash Destinations so that we don't break them disconnecting from Live
		$stash_active = false;
		foreach( pb_backupbuddy::$options['remote_destinations'] as $active_destination ) {
			if ( ! empty( $active_destination['type'] ) && substr($active_destination['type'], 0, 5 ) == 'stash' ) {
				$stash_active = true;
				continue;
			}
		}

		// Only check username/password if we're gonna kill the itxapi token (no stash destinations)
		if ( empty( $stash_active )  ) {
			// Pass itxapi_password to disconnect.
			global $wp_version;
			$password_hash = iThemes_Credentials::get_password_hash( $destination_settings['itxapi_username'], pb_backupbuddy::_POST( 'password' ) );
			$access_token = ITXAPI_Helper2::get_access_token( $destination_settings['itxapi_username'], $password_hash, site_url(), $wp_version );
			$settings = array(
				'itxapi_username' => $destination_settings['itxapi_username'],
				'itxapi_password' => $access_token,
				'itxapi_token' => $destination_settings['itxapi_token'],
			);
			$response = pb_backupbuddy_destination_live::stashAPI( $settings, 'disconnect' );
		
			if ( ! is_array( $response ) ) {
				pb_backupbuddy::alert( 'Error Disconnecting: ' . $response );
			} elseif ( ( ! isset( $response['success'] ) ) || ( '1' != $response['success'] ) ) {
				pb_backupbuddy::alert( 'Error #483948944. Unexpected response disconnecting: `' . print_r( $response, true ) . '`.' );
			} else {
				$disconnected = true;
			}
		} else {
			// We have other Stash destinations so disable live w/o actually disconnecting
			$disconnected = true;
		}
			
		// If we've determined it's okay to disconnect, continue Stash Live file purge and remove destination
		if ( ! empty( $disconnected ) ) {
			// Clear destination settings.
			unset( pb_backupbuddy::$options['remote_destinations'][ $liveDestinationID ] );
			pb_backupbuddy::save();
			
			// Clear cached Live credentials.
			require_once( pb_backupbuddy::plugin_path() . '/destinations/live/init.php' );
			delete_transient( pb_backupbuddy_destination_live::LIVE_ACTION_TRANSIENT_NAME );

			// Delete everything related to current Live backup process
			$live_serial = pb_backupbuddy::$options['log_serial'];
			if ( ! empty( $live_serial ) ) {
				backupbuddy_core::clearLiveLogs( $live_serial );
			}
			
			pb_backupbuddy::disalert( '', 'You have disconnected from Stash Live.' );
			$liveDestinationID = false;
		}
		
	}
	
	// Show authentication form.
	if ( false === $disconnected ) {
		if ( is_multisite() ) {
			$admin_url = network_admin_url( 'admin.php' );
		} else {
			$admin_url = admin_url( 'admin.php' );
		}
		?>
		<h3><?php _e( 'Disconnect from Stash Live', 'it-l10n-backupbuddy' ); ?></h3>
		<?php _e( 'To disconnect you must verify you have access to this account. Please authenticate with your iThemes Member Login to validate your access and disconnect this site from Stash Live.', 'it-l10n-backupbuddy' ); ?><br><br>
		<form method="post" action="<?php echo pb_backupbuddy::nonce_url( $admin_url . '?page=pb_backupbuddy_live&live_action=disconnect' ); ?>">
			<input type="hidden" name="disconnect" value="yes">
			<table>
				<tr>
					<td>iThemes Username:</td>
					<td><input type="text" name="username" value="<?php echo $destination_settings['itxapi_username']; ?>" readonly="true"></td>
				</tr>
				<tr>
					<td>iThemes Password:</td>
					<td><input type="password" name="password"></td>
				</tr>
				<tr><td colspan="2">&nbsp;</td></tr>
				<tr>
					<td>&nbsp;</td>
					<td>
						<input type="submit" name="submit" value="Disconnect Stash Live" class="button-primary">
					</td>
				</tr>
			</table>
		</form>
		<?php
		return;
	}
}



// Show setup screen if not yet set up.
if ( false === $liveDestinationID ) {
	require_once( pb_backupbuddy::plugin_path() . '/destinations/live/_live_setup.php' );
	return;
}



// Load normal manage page.


pb_backupbuddy::$ui->title( __( 'Stash Live', 'it-l10n-backupbuddy' ) );
?>
<br>

<script>
	jQuery(document).ready(function() {
		
		jQuery('#screen-meta-links').append(
			'<div id="backupbuddy-meta-link-wrap" class="hide-if-no-js screen-meta-toggle">' +
				'<a href="<?php echo pb_backupbuddy::nonce_url( $admin_url . '?page=pb_backupbuddy_live&live_action=troubleshooting' ); ?>" class="add-new-h2 show-settings no-dropdown"><?php _e( "Troubleshooting Scan", "it-l10n-backupbuddy" ); ?></a>' +
			'</div>'
		);
		
		jQuery('#screen-meta-links').append(
			'<div id="backupbuddy-meta-link-wrap" class="hide-if-no-js screen-meta-toggle">' +
				'<a href="<?php echo pb_backupbuddy::ajax_url( 'live_settings' ); ?>&#038;TB_iframe=1&#038;width=640&#038;height=600" class="add-new-h2 thickbox show-settings no-dropdown"><?php _e( "Live Settings", "it-l10n-backupbuddy" ); ?></a>' +
			'</div>'
		);
		
	});
	</script>

<?php
$destination = pb_backupbuddy::$options['remote_destinations'][ $liveDestinationID ];
$destination_id = $liveDestinationID;
require_once( pb_backupbuddy::plugin_path() . '/destinations/live/_manage.php' ); // Expects incoming vars: $destination, $destination_id.


