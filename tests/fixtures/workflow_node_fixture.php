<?php
/* WorkflowNode Fixture generated on: 2009-07-19 00:07:50 : 1247979050 */
class WorkflowNodeFixture extends CakeTestFixture {
	var $name = 'WorkflowNode';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'workflow_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'length' => 10, 'key' => 'index'),
		'class' => array('type'=>'string', 'type' => 'string', 'null' => false),
		'configuration' => array('type'=>'text', 'type' => 'text', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'workflow_id' => array('column' => 'workflow_id', 'unique' => 0))
	);
}
?>