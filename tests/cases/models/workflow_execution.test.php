<?php
/* WorkflowExecution Test cases generated on: 2009-07-19 00:07:42 : 1247979162*/
App::import('Model', 'workflow.WorkflowExecution');

class WorkflowExecutionTestCase extends CakeTestCase {
	function startTest() {
		$this->WorkflowExecution =& ClassRegistry::init('WorkflowExecution');
	}

	function endTest() {
		unset($this->WorkflowExecution);
		ClassRegistry::flush();
	}

}
?>