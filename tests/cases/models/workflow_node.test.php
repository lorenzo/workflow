<?php
/* WorkflowNode Test cases generated on: 2009-07-19 00:07:50 : 1247979050*/
App::import('Model', 'workflow.WorkflowNode');

class WorkflowNodeTestCase extends CakeTestCase {
	function startTest() {
		$this->WorkflowNode =& ClassRegistry::init('WorkflowNode');
	}

	function endTest() {
		unset($this->WorkflowNode);
		ClassRegistry::flush();
	}

}
?>