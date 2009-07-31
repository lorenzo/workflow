<?php
/* WorkflowWorkflow Test cases generated on: 2009-07-19 00:07:32 : 1247978912*/
App::import('Model', 'workflow.WorkflowWorkflowStorage');

class WorkflowWorkflowStorageTestCase extends CakeTestCase {
	function startTest() {
		$this->Storage =& ClassRegistry::init('WorkflowWorkflowStorage');
	}

	function endTest() {
		unset($this->Storage);
		ClassRegistry::flush();
	}

}
?>