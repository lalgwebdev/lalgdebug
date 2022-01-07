<?php

/************************************************************/
/*     LALG Various Debug Functions                    */
/************************************************************/

/************************************************************/
// Skeleton Pre and Post hooks
// Comment out the initial return; to enable.

function lalgdebug_civicrm_pre($op, $objectName, $id, &$params) {
	return;
	dpm('Pre_hook ' . $op . '  :  ' . $objectName . '  :  ' . $id);
	return;
	if ($objectName == 'Individual' || $objectName == 'Household') {
		dpm($params);
		lalg_debug_backtrace ("TRACE Pre Hook: " . $op . ' ' . $objectName);		  
	}
}

function lalgdebug_civicrm_post($op, $objectName, $objectId, &$objectRef) {
	return;
	dpm('Post_hook ' . $op . '  :  ' . $objectName . '  :  ' . $objectId);
	return;
	if ($objectName == 'Membership' || $objectName == 'Contribution' || $objectName == 'Payment') {
		dpm($objectRef);
		lalg_debug_backtrace ("TRACE Post Hook: " . $op . ' ' . $objectName);
	}
} 

/****************************************************************/
// Backtrace Lite - put summary trace in Error log
//   $message	Put into header of Trace

function lalg_debug_backtrace ($message) {
	$trace = debug_backtrace();
	$backtrace_lite = array();
	foreach( $trace as $call ) {
		$backtrace_lite[] = $call['function'] . "    " . $call['file'] . "    line " . $call['line'] . " ;;" ;
	}
	debug( $backtrace_lite, $message, true );
}

/*******************************************************************/
// Schedule Watchdog Mailing
// Creates and schedules a Watchdog CiviCRM Mailing once a day.

function lalgdebug_civicrm_cron($jobManager) {
	// Get most recent Watchdog Mailing
	$result = civicrm_api3('Mailing', 'get', [
	  'sequential' => 1,
	  'return' => ["id", "created_date"],
	  'name' => "Watchdog Mailing",
	  'options' => ['limit' => 1, 'sort' => "created_date DESC"],
	]);	

	// Exit if not found
	if ($result['count'] == 0) { return; }

	// Check have not created today's Watchdog already.
	$today = date("Y-m-d");
	$now = date("Y-m-d H:i:s");
		
	if ($result['values'][0]['created_date'] >= $today . ' 00:00:00') { return;}  	// Already done one today.
	
	// Clone this to make a new Mailing
	$result = civicrm_api3('Mailing', 'clone', [
	  'id' => $result['values'][0]['id'],
	]);
	
	// And schedule it for today
	$result = civicrm_api3('Mailing', 'create', [
	  'id' => $result['id'],
	  'scheduled_date' => $now,
	]);	
}


