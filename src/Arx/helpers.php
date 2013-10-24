<?php
/**
 * Helper loader for functions
 * @todo : better helper integrations via autoload functions
 */
use Arx\classes\Utils as u;

u::alias('predie', '\Arx\classes\Utils::predie'); # Do a better pre die

u::alias('ddd', '\Arx\classes\Utils::predie'); # An other link to Raveren/debug as dd is used by Laravel

u::alias('k', '\Arx\classes\Utils::k'); # do a debug line