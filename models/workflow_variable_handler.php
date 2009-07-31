<?php
class WorkflowVariableHandler extends WorkflowAppModel {
	var $name = 'WorkflowVariableHandler';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Workflow' => array(
			'className' => 'Workflow.WorkflowWorkflow',
			'foreignKey' => 'workflow_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>