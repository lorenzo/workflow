<?php
/* WorkflowWorkflow Fixture generated on: 2009-07-19 00:07:32 : 1247978912 */
class WorkflowWorkflowFixture extends CakeTestFixture {
	var $name = 'WorkflowWorkflow';

	var $fields = array(
		'id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type'=>'string', 'type' => 'string', 'null' => false, 'length' => 32, 'key' => 'index'),
		'version' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'default' => '1', 'length' => 10),
		'created' => array('type'=>'integer', 'type' => 'integer', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'name_version' => array('column' => array('name', 'version'), 'unique' => 1))
	);
}
?>