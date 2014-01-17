<?php
/**
 * Helper loader for functions
 * @todo : better helper integrations via autoload functions
 */
use Arx\classes\Utils as u;

if ( ! function_exists('\predie'))
{
    u::alias('\predie', '\Arx\classes\Utils::predie'); # Do a better pre die
}

if ( ! function_exists('\de'))
{
    u::alias('\de', '\Arx\classes\Utils::predie'); # A shortcode of Predie
}

if ( ! function_exists('\k'))
{
    u::alias('\k', '\Arx\classes\Utils::k'); # do a debug line
}