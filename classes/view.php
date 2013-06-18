<?php namespace Arx;

class c_view extends \Slim\View
{
    /**
     * @var string The path to the directory containing Savant3.php and the Savant3 folder without trailing slash.
     */
    public static $savantDirectory = null;

    /**
     * @var array The options for the Savant3 environment, see http://phpsavant.com/api/Savant3/
     */
    public static $savantOptions = array('template_path' => 'views');

    /**
     * @var persistent instance of the Savant object
     */
    private static $savantInstance = null;

    /**
     * Renders a template using Savant3.php.
     *
     * @see View::render()
     * @param string $template The template name specified in Slim::render()
     * @return string
     */
    public function render($template)
    {
        $savant = $this->getInstance();
        $savant->assign($this->data);

        return $savant->fetch($template);
    }

    /**
     * Creates new Savant instance if it doesn't already exist, and returns it.
     *
     * @throws RuntimeException If Savant3 lib directory does not exist.
     * @return SavantInstance
     */
    private function getInstance()
    {
        if (!self::$savantInstance) {
            if (!is_dir(self::$savantDirectory)) {
                throw new \RuntimeException('Cannot set the Savant lib directory : ' . self::$savantDirectory . '. Directory does not exist.');
            }

            self::$savantInstance = new c_template(self::$savantOptions);
        }

        return self::$savantInstance;
    }
}
