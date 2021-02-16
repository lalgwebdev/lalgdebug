<?php

/************************************************************/
/*     LALG Various Debug Functions                    */
/************************************************************/
 
/************************************************************/
// Skeleton Pre and Post hooks
// Comment out the initial return; to enable.

function lalgdebug_civicrm_pre($op, $objectName, $id, &$params) {
//	return;
	dpm('Pre_hook ' . $op . '  :  ' . $objectName . '  :  ' . $id);
	return;
	if ($objectName == 'Individual' || $objectName == 'Household') {
		dpm($params);
		lalg_debug_backtrace ("TRACE Pre Hook: " . $op . ' ' . $objectName);		  
	}
}

function lalgdebug_civicrm_post($op, $objectName, $objectId, &$objectRef) {
//	return;
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




