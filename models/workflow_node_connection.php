<?php
class WorkflowNodeConnection extends WorkflowAppModel {
	var $name = 'WorkflowNodeConnection';
	var $primaryKey = false;
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'IncomingNode' => array(
			'className' => 'Workflow.WorkflowNode',
			'foreignKey' => 'incoming_node_id',
			'type' => 'INNER',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'OutgoingNode' => array(
			'className' => 'Workflow.WorkflowNode',
			'foreignKey' => 'outgoing_node_id',
			'type' => 'INNER',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>