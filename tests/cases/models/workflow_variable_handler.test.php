<?php
/* WorkflowVariableHandler Test cases generated on: 2009-07-19 00:07:27 : 1247979387*/
App::import('Model', 'workflow.WorkflowVariableHandler');

class WorkflowVariableHandlerTestCase extends CakeTestCase {
	function startTest() {
		$this->WorkflowVariableHandler =& ClassRegistry::init('WorkflowVariableHandler');
	}

	function endTest() {
		unset($this->WorkflowVariableHandler);
		ClassRegistry::flush();
	}

}
?>