<?php
/* WorkflowVariableHandler Fixture generated on: 2009-07-19 00:07:27 : 1247979387 */
class WorkflowVariableHandlerFixture extends CakeTestFixture {
	var $name = 'WorkflowVariableHandler';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'workflow_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'length' => 10, 'key' => 'index'),
		'variable' => array('type'=>'string', 'type' => 'string', 'null' => false),
		'class' => array('type'=>'string', 'type' => 'string', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'workflow_id' => array('column' => array('workflow_id', 'class'), 'unique' => 1))
	);
}
?>