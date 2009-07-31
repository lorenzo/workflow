<?php
App::import('Model','workflow.WorkFlowWorkflow');
class WorkflowWorkflowStorage extends WorkflowWorkFlow Implements ezcWorkflowDefinitionStorage {
	var $name = 'WorkflowWorkflowStorage';
	var $useTable = false;
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	
	function save(ezcWorlflow $workflow) {
		
	}
	
	function loadByName($name,$version = 0) {
		
	}
}
?>