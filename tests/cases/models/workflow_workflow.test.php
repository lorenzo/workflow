<?php

App::import('Model', 'workflow.WorkflowWorkflow');

class MyServiceTestObject implements ezcWorkflowServiceObject {
	private $message;

 	public function __construct( $message ) {
		$this->message = $message;
	}
	
	public function execute( ezcWorkflowExecution $execution ) {
		echo $this->message;
		$execution->setVariable( 'choice', true );
		return true;
	}

	public function __toString() {
		return "MyServiceTestObject, message {$this->message}";
	}
}

class WorkflowWorkflowTestCase extends CakeTestCase {
	var $fixtures = array(
		'plugin.workflow.workflow_workflow',
		'plugin.workflow.workflow_node',
		'plugin.workflow.workflow_node_connection',
		'plugin.workflow.workflow_execution',
		'plugin.workflow.workflow_variable_handler'
	);
	
	function startTest() {
		$this->Workflow =& ClassRegistry::init('WorkflowWorkflow');
	}

	function endTest() {
		unset($this->WorkflowWorkflow);
		ClassRegistry::flush();
	}
	
	private function buildWorkflow() {
		$workflow = new ezcWorkflow( 'Test' );
		$input = new ezcWorkflowNodeInput(
			array( 'choice' => new ezcWorkflowConditionIsBool )
		);
		
		$workflow->startNode->addOutNode( $input );
		$branch = new ezcWorkflowNodeExclusiveChoice;
		$branch->addInNode( $input );
		
		$trueNode = new ezcWorkflowNodeAction( array( 'class' => 'MyServiceTestObject',
		 'arguments' => array( 'message: TRUE' ) )
		);
		$falseNode = new ezcWorkflowNodeAction( array( 'class' => 'MyServiceTestObject',
		 'arguments' => array( 'message: FALSE' ) )
		);
		
		$branch->addConditionalOutNode(
			new ezcWorkflowConditionVariable( 'choice', new ezcWorkflowConditionIsTrue ),
		$trueNode );
		$branch->addConditionalOutNode(
			new ezcWorkflowConditionVariable( 'choice', new ezcWorkflowConditionIsFalse ),
			$falseNode
		);
		$merge = new ezcWorkflowNodeSimpleMerge;
		$merge->addInNode( $trueNode );
		$merge->addInNode( $falseNode );
		$merge->addOutNode( $workflow->endNode );
		return $workflow;
	}
	
	function testSave() {
		$worflow = $this->buildWorkflow();
		//$this->Workflow->save($worflow);
	}
	
	function testLoad() {
		$expected = $this->buildWorkflow();
		$this->Workflow->save($expected);
		$id = $this->Workflow->id;
		$this->Workflow->create();
		$result = $this->Workflow->load($id);
		$this->assertEqual(count($result->nodes),count($expected->nodes));
		$resultNodes = array();
		$expectedNodes = array();
		
		foreach ($result->nodes as $node) {
			$resultNodes[] = $node;
		}
		foreach ($expected->nodes as $node) {
			$expectedNodes[] = $node;
		}
		
		foreach ($resultNodes as $i => $node) {
			$this->assertEqual(count($node->getInNodes()),count($expectedNodes[$i]->getInNodes()));
			$this->assertEqual(count($node->getOutNodes()),count($expectedNodes[$i]->getOutNodes()));
			$this->assertEqual($node->getConfiguration(),$expectedNodes[$i]->getConfiguration());
			$this->assertEqual(get_class($node),get_class($expectedNodes[$i]));
		}
		
	}
	
	function testLoadByName() {
		$workflow = $this->buildWorkflow();
		$this->Workflow->save($workflow);
		$this->Workflow->create();
		$this->Workflow->save($workflow);
		$name = $this->Workflow->field('name');
		$version = $this->Workflow->field('version');
		$this->assertEqual($name,'Test');
		$this->assertEqual($version,2);
		
		$expected = $workflow;
		$result = $this->Workflow->loadByName('Test',2);
		$this->assertTrue(is_a($result,'ezcWorkflow'));
		$this->assertEqual($version,$result->version);
		$this->assertEqual(count($result->nodes),count($expected->nodes));
		$resultNodes = array();
		$expectedNodes = array();
		
		foreach ($result->nodes as $node) {
			$resultNodes[] = $node;
		}
		foreach ($expected->nodes as $node) {
			$expectedNodes[] = $node;
		}
		
		foreach ($resultNodes as $i => $node) {
			$this->assertEqual(count($node->getInNodes()),count($expectedNodes[$i]->getInNodes()));
			$this->assertEqual(count($node->getOutNodes()),count($expectedNodes[$i]->getOutNodes()));
			$this->assertEqual($node->getConfiguration(),$expectedNodes[$i]->getConfiguration());
			$this->assertEqual(get_class($node),get_class($expectedNodes[$i]));
		}
	}
}
?>