<?php
backupbuddy_core::verifyAjaxAccess();


$log_file = backupbuddy_core::getLogDirectory() . 'log-' . pb_backupbuddy::$options['log_serial'] . '-remote_api.txt';
if ( file_exists( $log_file ) ) {
	readfile( $log_file );
} else {
	echo __('Nothing has been logged.', 'it-l10n-backupbuddy' );
}
die();