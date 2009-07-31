<?php

class CakeWorkflowExecution extends ezcWorkflowExecution {
	
	private $Execution;
	protected $loaded;
	
	public function __construct ($executionId = null) {
		if ($executionId !== null && !is_int( $executionId)){
			throw new Exception('$executionId must be an integer.');
		}
		
		$this->Execution = ClassRegistry::init('workflow.WorkflowExecution');
		if (is_int($executionId)) {
			$this->loadExecution($executionId);
		}
	}
	
	protected function doStart($parentId) {
		$execution = array(
			'workflow_id' => $this->workflow->id,
			'parent_id' => $parentId,
			'started' => time(),
			'variables' => serialize($this->variables),
			'waiting_for' => serialize($this->waitingFor),
			'threads' => serialize($this->threads),
			'next_thread_id' => $this->nextThreadId
		);
		$this->Execution->save($execution);
		$this->id = $this->Execution->id;
	}
	
	protected function doSuspend() {
		$this->Execution->id = $this->id;
		$execution = array(
			'variables' => serialize($this->variables),
			'waiting_for' => serialize($this->waitingFor),
			'threads' => serialize($this->threads),
			'next_thread_id' => $this->nextThreadId
		);
		$this->Execution->save($execution);
		
		foreach ($this->activatedNodes as $node) {
			$state = array(
				'execution_id' => $this->id,
				'node_id' => $node->getId(),
				'state' => serialize($node->getState()),
				'activated_from' => serialize($node->getActivatedFrom()),
				'node_thread_id' => $node->getThreadId()
			);
			$this->Execution->State->create();
			$this->Execution->State->save($state);
		}
	}
	
	protected function doResume() {
		$this->Execution->State->deleteAll(array('State.execution_id' => $this->id));
	}
	
	protected function doEnd() {
		$this->Execution->deleteAll(array('WorkflowExecution.id' => $this->id));
		$this->Execution->State->deleteAll(array('execution_id' => $this->id));
	}
	
	protected function doGetSubExecution($id = null) {
		return new CakeWorkflowExecution($id);
	}

	protected function loadExecution($executionId) {
		$execution = $this->Execution->read(null,$executionId);
		
		if (empty($execution)) {
			throw new Exception('Could not load execution state.');
		}
		
		$this->id = $executionId;
		$this->nextThreadId = $execution['WorkflowExecution']['next_thread_id'];
		$this->threads = unserialize($execution['WorkflowExecution']['threads']);
		$this->variables = unserialize($execution['WorkflowExecution']['variables']);
		$this->waitingFor = unserialize($execution['WorkflowExecution']['waiting_for']);
		$workflowId = $execution['WorkflowExecution']['workflow_id'];
		$this->workflow = $this->Execution->Workflow->load($workflowId);
		
      $activatedNodes = array();
		foreach ($execution['State'] as $state) {
			$activatedNodes[$state['node_id']] = array(
				'state' => $state['state'],
				'activated_from' => $state['activated_from'],
				'thread_id' => $state['thread_id']
			);
		}
		
		foreach ($this->workflow->nodes as $node) {
			$nodeId = $node->getId();
			if (isset($activatedNodes[$nodeId])) {
				$node->setActivationState(ezcWorkflowNode::WAITING_FOR_EXECUTION);
				$node->setThreadId($activatedNodes[$nodeId]['thread_id']);
				$node->setState(unserialize($activatedNodes[$nodeId]['state']));
				$node->setActivatedFrom(unserialize($activatedNodes[$nodeId]['activated_from']));
				$this->activate( $node, false );
			}
		}
		$this->cancelled = false;
		$this->ended     = false;
		$this->loaded    = true;
		$this->resumed   = false;
		$this->suspended = true;
    }
}