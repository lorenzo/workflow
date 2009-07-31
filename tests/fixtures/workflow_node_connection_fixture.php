<?php
/* WorkflowNodeConnection Fixture generated on: 2009-07-19 00:07:26 : 1247981366 */
class WorkflowNodeConnectionFixture extends CakeTestFixture {
	var $name = 'WorkflowNodeConnection';

	var $fields = array(
		'incoming_node_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'length' => 10, 'key' => 'index'),
		'outgoing_node_id' => array('type'=>'integer', 'type' => 'integer', 'null' => false, 'length' => 10),
		'indexes' => array('incoming_node_id' => array('column' => 'incoming_node_id', 'unique' => 0))
	);
}
?>