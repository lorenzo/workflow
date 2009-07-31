<?php
class WorkflowExecution extends WorkflowAppModel {
	var $name = 'WorkflowExecution';
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Workflow' => array(
			'className' => 'Workflow.WorkflowWorkflow',
			'foreignKey' => 'workflow_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'ParentWorkflowExecution' => array(
			'className' => 'Workflow.WorkflowExecution',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'ChildWorkflowExecution' => array(
			'className' => 'Workflow.WorkflowExecution',
			'foreignKey' => 'parent_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => true,
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'State' => array(
			'className' => 'Workflow.WorkflowExecutionState',
			'foreignKey' => 'execution_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => true,
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

}
?>