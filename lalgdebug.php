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

/***************************************************************/
// Tests for patch to civicrm_entity invoking hooks

function lalgdebug_civicrm_alter_drupal_entities($entities) {
return;
	dpm('Called hook civicrm_alter_drupal_entities');
	dpm($entities);
}

function lalgdebug_civicrm_entity_supported_info($info) {
return;
	dpm('Called hook civicrm_entity_supported_info');
	dpm($info);
}

function lalgdebug_civicrm_alter_drupal_entity_labels($labels) {
return;
	dpm('Called hook civicrm_alter_drupal_entity_labels');
	dpm($labels);
}

/***************************************************************/
// Tests for patch to CiviRules invoking hooks (1 of 4 cases)

function lalgdebug_civirules_alter_trigger_data ($triggerdata) {
return;
	dpm('Called hook civirules_alter_trigger_data');
	dpm($triggerdata);
}


