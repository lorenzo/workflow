<?php 
/* SVN FILE: $Id$ */
/* Workflow schema generated on: 2009-07-31 10:07:59 : 1249053959*/
class WorkflowSchema extends CakeSchema {
	var $name = 'Workflow';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $workflow_execution_states = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'execution_id' => array('type' => 'integer', 'null' => false, 'length' => 10, 'key' => 'unique'),
		'node_id' => array('type' => 'integer', 'null' => false, 'length' => 10),
		'state' => array('type' => 'text', 'null' => false),
		'activated_from' => array('type' => 'text', 'null' => false),
		'thread_id' => array('type' => 'integer', 'null' => false, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'execution_id' => array('column' => array('execution_id', 'node_id'), 'unique' => 1), 'execution_id_2' => array('column' => 'execution_id', 'unique' => 1))
	);
	var $workflow_executions = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'workflow_id' => array('type' => 'integer', 'null' => false, 'length' => 10),
		'parent_id' => array('type' => 'integer', 'null' => false, 'length' => 10, 'key' => 'index'),
		'started' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'variables' => array('type' => 'text', 'null' => false),
		'waiting_for' => array('type' => 'text', 'null' => false),
		'threads' => array('type' => 'text', 'null' => false),
		'next_thread_id' => array('type' => 'integer', 'null' => false, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'execution_parent' => array('column' => 'parent_id', 'unique' => 0))
	);
	var $workflow_node_connections = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'incoming_node_id' => array('type' => 'integer', 'null' => false, 'length' => 10),
		'outgoing_node_id' => array('type' => 'integer', 'null' => false, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
	var $workflow_nodes = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'workflow_id' => array('type' => 'integer', 'null' => false, 'length' => 10, 'key' => 'index'),
		'class' => array('type' => 'string', 'null' => false),
		'configuration' => array('type' => 'text', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'workflow_id' => array('column' => 'workflow_id', 'unique' => 0))
	);
	var $workflow_variable_handlers = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'workflow_id' => array('type' => 'integer', 'null' => false, 'length' => 10, 'key' => 'index'),
		'variable' => array('type' => 'string', 'null' => false),
		'class' => array('type' => 'string', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'workflow_id' => array('column' => array('workflow_id', 'class'), 'unique' => 1))
	);
	var $workflow_workflows = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 32, 'key' => 'index'),
		'version' => array('type' => 'integer', 'null' => false, 'default' => '1', 'length' => 10),
		'created' => array('type' => 'integer', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'name_version' => array('column' => array('name', 'version'), 'unique' => 1))
	);
}
?>