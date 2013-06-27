<?php
/**
 * A Vimeo adapter
 *
 * @param $
 *
 * @return
 *
 * @code
 *
 * @endcode
 */

require_once DIR_VENDOR. DS. 'vimeo'.DS.'vimeo'.EXT_PHP;

class a_vimeo extends phpVimeo
{
    public function __construct()
    {
        $aArgs = func_get_args();

        $iNbArgs = func_num_args();

        switch (true) {
            // Case we add param
            case ($iNbArgs == 1 && is_array($aArgs[0])):
                parent::__construct($aArgs[0], $aArgs[0]);
            break;

            // Case we add consumer key
            case ($iNbArgs == 2 && is_string($aArgs[0]) && is_string($aArgs[1])):
                parent::__construct($aArgs[0], $aArgs[0]);
            break;

            //default case
            default:
                parent::__construct($GLOBALS['vimeo']['CONSUMER_KEY'], $GLOBALS['vimeo']['CONSUMER_SECRET']);
            break;
        }

    }

}
