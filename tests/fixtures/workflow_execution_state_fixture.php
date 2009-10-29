<?php
class WorkflowExecutionStateFixture extends CakeTestFixture {
	var $name = 'WorkflowExecutionState';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'node_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false),
		'execution_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false),
		'state' => array('type'=>'string', 'type' => 'string'),
		'activated_from' => array('type'=>'string', 'type' => 'string'),
		'thread_id' => array('type'=>'integer', 'type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1))
	);
}
?>