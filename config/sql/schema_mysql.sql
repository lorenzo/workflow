CREATE TABLE workflow_workflows (
  id                INTEGER      UNSIGNED NOT NULL AUTO_INCREMENT,
  name              VARCHAR(32)           NOT NULL,
  version           INTEGER      UNSIGNED NOT NULL DEFAULT 1,
  created           INTEGER               NOT NULL,

  PRIMARY KEY              (id),
  UNIQUE  KEY name_version (name, version)
) ENGINE=InnoDB;

CREATE TABLE workflow_nodes (
  id            INTEGER      UNSIGNED NOT NULL AUTO_INCREMENT,
  workflow_id   INTEGER      UNSIGNED NOT NULL REFERENCES workflow_workflows.id,
  class         VARCHAR(255)          NOT NULL,
  configuration TEXT                  NOT NULL,

  PRIMARY KEY             (id),
          KEY workflow_id (workflow_id)
) ENGINE=InnoDB;

CREATE TABLE workflow_node_connections (
  incoming_node_id INTEGER UNSIGNED NOT NULL,
  outgoing_node_id INTEGER UNSIGNED NOT NULL,

  KEY incoming_node_id (incoming_node_id)
) ENGINE=InnoDB;

CREATE TABLE workflow_variable_handlers (
  id             				INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  workflow_id   INTEGER    UNSIGNED NOT NULL REFERENCES workflow_workflows.id,
  variable      VARCHAR(255)          NOT NULL,
  class         VARCHAR(255)          NOT NULL,

  PRIMARY KEY (id),
  UNIQUE KEY (workflow_id, class)
) ENGINE=InnoDB;

CREATE TABLE workflow_executions (
  id             				INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  workflow_id              INTEGER UNSIGNED NOT NULL REFERENCES workflow_workflows.id,
  parent_id         			INTEGER UNSIGNED NOT NULL REFERENCES workflow_executions.id,
  started       				TINYINT(1)       NOT NULL,
  variables   				   TEXT             NOT NULL,
  waiting_for    				TEXT             NOT NULL,
  threads   			      TEXT             NOT NULL,
  next_thread_id 				INTEGER UNSIGNED NOT NULL,

  PRIMARY KEY                 (id),
  KEY execution_parent 			(parent_id)
) ENGINE=InnoDB;

CREATE TABLE workflow_execution_states (
  id             			INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  execution_id          INTEGER UNSIGNED NOT NULL REFERENCES workflow_executions.id,
  node_id               INTEGER UNSIGNED NOT NULL REFERENCES workflow_nodes.id,
  state            		TEXT             NOT NULL,
  activated_from  		TEXT             NOT NULL,
  thread_id       		INTEGER UNSIGNED NOT NULL,

  PRIMARY KEY (id),
  UNIQUE KEY (execution_id, node_id)
) ENGINE=InnoDB;