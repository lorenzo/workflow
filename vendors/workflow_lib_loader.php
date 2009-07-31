<?php

$here = dirname(__FILE__) . DS;
require $here. 'ezc' . DS . 'Base' . DS . 'src' . DS . 'base.php';
spl_autoload_register(array( 'ezcBase', 'autoload' ));