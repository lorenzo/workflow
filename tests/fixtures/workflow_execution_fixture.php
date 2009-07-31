<?php
/* WorkflowExecution Fixture generated on: 2009-07-19 00:07:42 : 1247979162 */
class WorkflowExecutionFixture extends CakeTestFixture {
	var $name = 'WorkflowExecution';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'workflow_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'length' => 10),
		'parent_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'length' => 10, 'key' => 'index'),
		'started' => array('type'=>'boolean', 'type' => 'boolean', 'null' => false),
		'variables' => array('type'=>'text', 'type' => 'text', 'null' => false),
		'waiting_for' => array('type'=>'text', 'type' => 'text', 'null' => false),
		'threads' => array('type'=>'text', 'type' => 'text', 'null' => false),
		'next_thread_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'length' => 10),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'execution_parent' => array('column' => 'parent_id', 'unique' => 0))
	);
}
?>