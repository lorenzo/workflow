<?php
/* WorkflowNodeConnection Test cases generated on: 2009-07-19 00:07:26 : 1247981366*/
App::import('Model', 'workflow.WorkflowNodeConnection');

class WorkflowNodeConnectionTestCase extends CakeTestCase {
	function startTest() {
		$this->WorkflowNodeConnection =& ClassRegistry::init('WorkflowNodeConnection');
	}

	function endTest() {
		unset($this->WorkflowNodeConnection);
		ClassRegistry::flush();
	}

}
?>