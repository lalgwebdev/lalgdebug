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
	if ($objectName == 'LineItem' || $objectName == 'Contribution' || $objectName == 'FinancialItem') {
		dpm($params);
		lalg_debug_backtrace ("TRACE Pre Hook: " . $op . ' ' . $objectName);	
	}
}

function lalgdebug_civicrm_post($op, $objectName, $objectId, &$objectRef) {
	return;
	dpm('Post_hook ' . $op . '  :  ' . $objectName . '  :  ' . $objectId);
	return;
	if ($objectName == 'LineItem' || $objectName == 'Contribution' || $objectName == 'FinancialItem') {
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

/****************************************************************/
// DBtrace - Display tail of selected DB table 
// NOTE:  Will need editing for different structure of each table.

function lalg_debug_DBtrace ($message, $table, $limit = 3) {
	$query = 'SELECT * FROM ' . $table . ' ORDER BY id DESC LIMIT ' . $limit . ';';
	$params = [];
	$dao =& CRM_Core_DAO::executeQuery($query, $params);
	$rows = array();
    while ($dao->fetch()) {
        $row = array();
        $row['id'] = $dao->id;
		$row['entity_table'] = $dao->entity_table;
		$row['entity_id'] = $dao->entity_id;
		$row['financial_trxn_id'] = $dao->financial_trxn_id;
        $rows[] = $row;
    }
	dpm($rows);
} 



