<?php
// No PHP runtime calculated yet. Try to see if test is finished.
if ( 0 == pb_backupbuddy::$options['tested_php_runtime'] ) {
	backupbuddy_core::php_runtime_test_results();
}

// Check if Godaddy Managed WordPress hosting.
if ( defined( 'GD_SYSTEM_PLUGIN_DIR' ) || class_exists( '\\WPaaS\\Plugin' ) ) {
	echo '<br>';
	pb_backupbuddy::disalert( 'godaddy_managed_wp_detected', __( '<span style="font-size:1.5em;font-weight:bold;">GoDaddy Managed WordPress Hosting Detected</span><br><br>GoDaddy\'s Managed WordPress Hosting recently experienced problems resulting in the WordPress cron not working properly resulting in WordPress\' built-in scheduling and automation functionality malfunctioning. <b>GoDaddy has addressed this issue for US-based customers and we believe it to be resolved for those hosted in the USA. Non-US customers should contact GoDaddy support.</b><br><br>However, if you still experience issues and require a partial workaround go to BackupBuddy -> "Settings" page -> "Advanced Settings / Troubleshooting" tab -> Check the box "Force internal cron" -> Scroll down and "Save" the settings.  This may help you be able to make a manual traditional backup though it may be slow and is not guaranteed.', 'it-l10n-backupbuddy' ) );
}


// Multisite Export. This file loaded from multisite_export.php.
if ( isset( $export_only ) && ( $export_only === true ) ) {
	if ( pb_backupbuddy::_GET( 'backupbuddy_backup' ) == '' ) {
		// Do nothing.
	} elseif ( pb_backupbuddy::_GET( 'backupbuddy_backup' ) == 'export' ) {
		require_once( '_backup-perform.php' );
	} else {
		die( '{Unknown backup type.}' );
	}
	
	return;
}



if ( pb_backupbuddy::_GET( 'custom' ) != '' ) { // Custom page.
	
	if ( pb_backupbuddy::_GET( 'custom' ) == 'remoteclient' ) {
		//require_once( '_remote_client.php' );
		die( 'Fatal Error #847387344: Obselete URL. Use remoteClient AJAX URL.' );
	} else {
		die( 'Unknown custom page. Error #4385489545.' );
	}
	
} else { // Normal backup page.
	if ( pb_backupbuddy::_GET( 'backupbuddy_backup' ) == '' ) {
		require_once( '_backup-home.php' );
	} else {
		require_once( '_backup-perform.php' );
	}

}
