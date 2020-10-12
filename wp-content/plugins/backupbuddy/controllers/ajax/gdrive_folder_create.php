<?php
backupbuddy_core::verifyAjaxAccess();


pb_backupbuddy::load();

//$destinationID = pb_backupbuddy::_POST( 'destinationID' ); // BackupBuddy destination ID number for remote destinations array.
$parentID = pb_backupbuddy::_POST( 'parentID' ); // Gdrive folder parent ID to list within. Use ROOT for looking in root of account.
$parentID = str_replace( array( '\\', '/', "'", '"' ), '', $parentID );
$folderName = pb_backupbuddy::_POST( 'folderName' ); // BackupBuddy destination ID number for remote destinations array.

/*
if ( ( '' == $destinationID ) || ( ! is_numeric( $destinationID ) ) || ( '' == $parentID ) || ( '' == $folderName ) ) {
	die( json_encode( array( 'success' => false, 'message' => 'Missing or invalid required parameter.' ) ) );
}

if ( ! isset( pb_backupbuddy::$options['remote_destinations'][ $destinationID ] ) ) {
	die( json_encode( array( 'success' => false, 'message' => 'Invalid remote destination ID number.' ) ) );
}
*/

$settings = array();
$clientID = pb_backupbuddy::_POST( 'clientID' );
$clientSecret = pb_backupbuddy::_POST( 'clientSecret' );
$tokens = pb_backupbuddy::_POST( 'tokens' );

$service_account_email = pb_backupbuddy::_POST( 'service_account_email' );
$service_account_file = pb_backupbuddy::_POST( 'service_account_file' );
$settings['service_account_email'] = $service_account_email;
$settings['service_account_file'] = $service_account_file;

$settings['client_id'] = $clientID;
$settings['client_secret'] = $clientSecret;
$settings['tokens'] = $tokens;


require_once( pb_backupbuddy::plugin_path() . '/destinations/gdrive/init.php' );
$returnFiles = array();


if ( false === ( $response = pb_backupbuddy_destination_gdrive::createFolder( $settings, $parentID, $folderName ) ) ) { // Failed pb_backupbuddy::$options['remote_destinations'][ $destinationID ]
	die(); // Function will have echo'd out the error already.
} else { // Success
	die( json_encode( array( 'success' => true, 'folderID' => $response[0], 'folderTitle' => $response[1] ) ) );
}