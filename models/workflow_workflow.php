<?php
class WorkflowWorkflow extends WorkflowAppModel Implements ezcWorkflowDefinitionStorage {
	var $name = 'WorkflowWorkflow';
	var $displayField = 'name';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasMany = array(
		'Node' => array(
			'className' => 'Workflow.WorkflowNode',
			'foreignKey' => 'workflow_id',
			'dependent' => true,
			'exclusive' => true,
		),
		'VariableHandler' => array(
			'className' => 'Workflow.WorkflowVariableHandler',
			'foreignKey' => 'workflow_id',
			'dependent' => true,
			'exclusive' => true,
		)
	);
	
	
	function save(ezcWorkflow $workflow) {
		$workflow->verify();
		$version = $this->currentVersion($workflow->name) + 1;
		
		$db = ConnectionManager::getDataSource('default');
		$db->begin($this);
		
		$data = array();
		$data[$this->alias]['name'] = $workflow->name;
		$data[$this->alias]['version'] = $version;
		
		if (!parent::save($data)) {
			$db->rollback($this);
			return false;
		}
		
		$data = array();
		$nodes = $workflow->nodes;
		foreach ($nodes as $node) {
			$data['Node'] = array(
				'class' => get_class($node),
				'configuration' => serialize($node->getConfiguration()),
				'workflow_id' => $this->id
			);
			$this->Node->create();
			if (!$this->Node->save($data)) {
				$db->rollback($this);
				return false;
			}
			$node->setId($this->Node->id);
		}
		
		foreach ($nodes as $node) {
			$data = array();
			foreach ($node->getOutNodes() as $outNode) {
				$data['WorkflowNodeConnection']['incoming_node_id'] = $node->getId();
				$data['WorkflowNodeConnection']['outgoing_node_id'] = $outNode->getId();
				$this->Node->WorkflowNodeConnection->create();
				if (!$this->Node->WorkflowNodeConnection->save($data)) {
					$db->rollback($this);
					return false;
				}
			}
		}
		
		$data = array();
		foreach ($workflow->getVariableHandlers() as $variable => $class) {
			$data['VariableHandler']['variable'] = $variable;
			$data['VariableHandler']['class'] = $class;
			$data['VariableHandler']['workflow_id'] = $this->id;
			if (!$this->VariableHandler->save($data)) {
				$db->rollback($this);
				return false;
			}
		}
		
		$db->commit($this);
		return true;
	}
	
	function currentVersion($name) {
		$version =  $this->find('first',array(
			'fields' => "MAX(version) as current",
			'conditions' => array('name' => $name),
			'recursive' => -1
		));
		
		if (empty($version))
			return null;
		
		return (int)$version[0]['current'];
	}
	
	public function load($id) {
		$workflow = $this->read(null,$id);
		
		if (empty($workflow)) {
			throw new ezcWorkflowDefinitionStorageException(
				'Could not load workflow definition.'
			);
		}
		
		$mappedNodes = array();
		
		foreach ($workflow['Node'] as $i => $node) {
			$configuration = unserialize($node['configuration']);
			
			if (is_null($configuration)) {
				$configuration = ezcWorkflowUtil::getDefaultConfiguration($node['class']);
			}
			
			$nodes[$i] = new $node['class'](
				$configuration
			);
			
			if ($nodes[$i] instanceof ezcWorkflowNodeFinally && !isset($finallyNode)) {
					
				$finallyNode = $nodes[$i];
					
			} else if ($nodes[$i] instanceof ezcWorkflowNodeEnd && !isset($defaultEndNode)) {
					
				$defaultEndNode = $nodes[$i];
	
			} else if ($nodes[$i] instanceof ezcWorkflowNodeStart && !isset($startNode)) {
				
				$startNode = $nodes[$i];	
			}
			
			$mappedNodes[$node['id']] = $i;
		}
		
		if (!isset($startNode) || !isset($defaultEndNode)) {
			throw new ezcWorkflowDefinitionStorageException(
				'Could not load workflow definition.'
			);
		}

		$connections = $this->Node->WorkflowNodeConnection->find('all',array(
			'fields' => array('incoming_node_id','outgoing_node_id'),
			'conditions' => array(
				'IncomingNode.workflow_id' => $this->id,
				'OutgoingNode.workflow_id' => $this->id,
				)
		));
		
		foreach ($connections as $connection) {
			$nodes[$mappedNodes[$connection['WorkflowNodeConnection']['incoming_node_id']]]->addOutNode(
				$nodes[$mappedNodes[$connection['WorkflowNodeConnection']['outgoing_node_id']]]
			);
		}
		
		if (!isset($finallyNode) || count($finallyNode->getInNodes() > 0)) {
			$finallyNode = null;
		}
		
		$workflow = new ezcWorkflow($this->data[$this->alias]['name'],$startNode,$defaultEndNode,$finallyNode);
		$workflow->definitionStorage = $this;
		$workflow->id = (int)$this->id;
		$workflow->version = (int)$this->data[$this->alias]['version'];
		
		foreach ($this->data['VariableHandler'] as $variableHandler) {
			$workflow->addVariableHandler($variableHandler['variable'],$variableHandler['class']);
		}
		
		$workflow->verify();
		return $workflow;
	}
	
	public function loadByName($name,$version = 0) {
		$id = $this->field('id',array(
			$this->alias.'.name' => $name, $this->alias . '.version' => $version
			)
		);
		return $this->load($id);
	}
}
?>