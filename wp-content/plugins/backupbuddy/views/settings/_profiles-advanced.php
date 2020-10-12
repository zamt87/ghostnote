<?php
if ( !is_admin() ) { die( 'Access Denied.' ); }


/*
IMPORTANT INCOMING VARIABLES (expected to be set before this file is loaded):
$profile	Index number of profile.
*/
if ( isset( pb_backupbuddy::$options['profiles'][$profile] ) ) {
	$profile_id = $profile;
	$profile_array = &pb_backupbuddy::$options['profiles'][$profile];
	$profile_array = array_merge( pb_backupbuddy::settings( 'profile_defaults' ), $profile_array );
} else {
	die( 'Error #565676756. Invalid profile ID index.' );
}


$settings_form->add_setting( array(
	'type'		=>		'title',
	'name'		=>		'title_advanced',
	'title'		=>		__( 'Advanced', 'it-l10n-backupbuddy' ),
) );

if ( $profile_array['type'] != 'defaults' ) {
	if ( ( 'files' != pb_backupbuddy::$options['profiles'][$profile]['type'] ) && ( 'themes' != pb_backupbuddy::$options['profiles'][$profile]['type'] ) && ( 'plugins' != pb_backupbuddy::$options['profiles'][$profile]['type'] ) && ( 'media' != pb_backupbuddy::$options['profiles'][$profile]['type'] ) ) {
		$settings_form->add_setting( array(
			'type'		=>		'radio',
			'name'		=>		'profiles#' . $profile_id . '#skip_database_dump',
			'options'	=>		array( '-1' => 'Use global default', '1' => 'Skip', '0' => 'Do not skip' ),
			'title'		=>		__('Skip database dump on backup', 'it-l10n-backupbuddy' ),
			'tip'		=>		__('[Default: disabled] - (WARNING: This prevents BackupBuddy from backing up the database during any kind of backup. This is for troubleshooting / advanced usage only to work around being unable to backup the database.', 'it-l10n-backupbuddy' ),
			'css'		=>		'',
			//'after'		=>		'<br><span class="description"> ' . __('Use with caution.', 'it-l10n-backupbuddy' ) . '</span>',
			'rules'		=>		'required',
			'orientation' =>	'vertical',
		) );
	}


/*
	$settings_form->add_setting( array(
		'type'		=>		'radio',
		'name'		=>		'profiles#' . $profile_id . '#compression',
		'options'	=>		array( '-1' => 'Use global default', '0' => 'Disable compression', '1' => 'Enable compression' ),
		'title'		=>		__( 'Enable zip compression', 'it-l10n-backupbuddy' ),
		'tip'		=>		__( '[Default: enabled] - ZIP compression decreases file sizes of stored backups. If you are encountering timeouts due to the script running too long, disabling compression may allow the process to complete faster.', 'it-l10n-backupbuddy' ),
		'css'		=>		'',
		'after'		=>		'<br><span class="description"> ' . __('Disable for large sites causing backups to not complete.', 'it-l10n-backupbuddy' ) . '</span>',
		'rules'		=>		'required',
	) );
*/


	$settings_form->add_setting( array(
		'type'		=>		'radio',
		'name'		=>		'profiles#' . $profile_id . '#integrity_check',
		'options'	=>		array( '-1' => 'Use global default', '0' => 'Disable check (' . __( 'Disable if directed by support', 'it-l10n-backupbuddy' ) . ')', '1' => 'Enable check' ),
		'title'		=>		__('Perform integrity check on backup files', 'it-l10n-backupbuddy' ),
		'tip'		=>		__('[Default: enabled] - WARNING: USE WITH CAUTION! By default each backup file is checked for integrity and completion the first time it is viewed on the Backup page.  On some server configurations this may cause memory problems as the integrity checking process is intensive.  This may also be useful if the backup page will not load.', 'it-l10n-backupbuddy' ),
		'css'		=>		'',
		'rules'		=>		'required',
		'orientation' =>	'vertical',
	) );
	
	$settings_form->add_setting( array(
		'type'		=>		'select',
		'name'		=>		'profiles#' . $profile_id . '#backup_mode',
		'title'		=>		__('Backup mode', 'it-l10n-backupbuddy' ),
		'options'	=>		array(
									'-1'		=>		__( 'Use global default', 'it-l10n-backupbuddy' ),
									'1'		=>		__( 'Classic (v1.x) - Entire backup in single PHP page load', 'it-l10n-backupbuddy' ),
									'2'		=>		__( 'Modern (v2.x+) - Split across page loads via WP cron', 'it-l10n-backupbuddy' ),
								),
		'tip'		=>		__('[Default: Modern] - If you are encountering difficulty backing up due to WordPress cron, HTTP Loopbacks, or other features specific to version 2.x you can try classic mode which runs like BackupBuddy v1.x did.', 'it-l10n-backupbuddy' ),
		'rules'		=>		'required',
	) );
}

