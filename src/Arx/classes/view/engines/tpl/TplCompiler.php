<?php namespace Arx\classes\view\engines\tpl;

use Closure;
use Illuminate\Filesystem\Filesystem;

use Illuminate\View\Compilers\BladeCompiler as ParentClass;

class TplCompiler extends ParentClass {

    /**
     * All of the registered extensions.
     *
     * @var array
     */
    protected $extensions = array();

    /**
     * All of the available compiler functions.
     *
     * @var array
     */
    protected $compilers = array(
        'Extensions',
        'Extends',
        'Comments',
        'Echos',
        'Openings',
        'Closings',
        'Else',
        'Unless',
        'EndUnless',
        'Includes',
        'Each',
        'Yields',
        'Shows',
        'Language',
        'SectionStart',
        'SectionStop',
        'SectionOverwrite',
    );

    /**
     * Array of opening and closing tags for echos.
     *
     * @var array
     */
    protected $contentTags = array('<%', '%>');

    /**
     * Array of opening and closing tags for escaped echos.
     *
     * @var array
     */
    protected $escapedTags = array('<%%', '%%>');

    /**
     * Compile Blade comments into valid PHP.
     *
     * @param  string  $value
     * @return string
     */
    protected function compileComments($value)
    {
        $pattern = sprintf('/%s--((.|\s)*?)--%s/', $this->contentTags[0], $this->contentTags[1]);

        return preg_replace($pattern, '<?php /* $1 */ ?>', $value);
    }

}