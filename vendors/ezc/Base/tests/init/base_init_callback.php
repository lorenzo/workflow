<?php
/**
 * @package Base
 * @subpackage Tests
 * @version 1.7
 * @copyright Copyright (C) 2005-2009 eZ Systems AS. All rights reserved.
 * @license http://ez.no/licenses/new_bsd New BSD License
 */

/**
 * Test class for ezcBaseInitTest.
 *
 * @package Base
 * @subpackage Tests
 */
class testBaseInitCallback implements ezcBaseConfigurationInitializer
{
    static public function configureObject( $objectToConfigure )
    {
        $objectToConfigure->configured = true;
    }
}
?>
