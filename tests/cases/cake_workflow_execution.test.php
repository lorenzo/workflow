<?php

App::import('Model', 'workflow.WorkflowWorkflow');
App::import('Vendor', 'workflow.CakeWorkflowExecution');

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

class CakeWorkflowExecutionTestCase extends CakeTestCase {
	var $fixtures = array(
		'plugin.workflow.workflow_workflow',
		'plugin.workflow.workflow_node',
		'plugin.workflow.workflow_node_connection',
		'plugin.workflow.workflow_execution',
		'plugin.workflow.workflow_variable_handler',
		'plugin.workflow.workflow_execution_state',
	);
	
	function startTest() {
		$this->Definition = ClassRegistry::init('WorkflowWorkflow');
	}

	function endTest() {
		unset($this->Definition);
		ClassRegistry::flush();
	}
	
	
	private function buildWorkflow() {
			$workflow = new ezcWorkflow( 'Test' );
			$initNode = new ezcWorkflowNodeVariableSet(array('init' => 'testValue'));
			$input = new ezcWorkflowNodeInput(
				array( 'choice' => new ezcWorkflowConditionIsBool )
			);

			$workflow->startNode->addOutNode( $initNode );
			$initNode->addOutNode($input); 
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
	
	function testSimpleExecution() {
		$workflow = $this->buildWorkflow();
		$this->Definition->save($workflow);
		$workflow = $this->Definition->loadByName('Test');
		$execution = new CakeWorkflowExecution();
		$execution->workflow = $workflow;
		$id = $execution->start();
		$this->assertEqual(1,count($execution->getActivatedNodes()));
		$this->assertTrue($execution->isSuspended());
		//At this point the execution is automatically suspended waiting for an input varible "choice"
		//Lets resume it from anther excecution object
		$execution = new CakeWorkflowExecution($id);
		$this->assertEqual('testValue',$execution->getVariable('init'));
		$waitingFor = $execution->getWaitingFor();
		$this->assertEqual('choice',key($execution->getWaitingFor()));
		
		//Let's cancell it
		$execution->cancel();
		// And try to resume it again
		try {
			$execution = new CakeWorkflowExecution($id);
		} catch (Exception $e) {
			$this->assertNotNull($e->getMessage());
		}
		
	}
	
}