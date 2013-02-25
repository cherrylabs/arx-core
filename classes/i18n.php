<?php

/**
 * Internationalization (i18n) class. Provides language loading and translation
 * methods without dependencies on [gettext](http://php.net/gettext).
 *
 * Typically this class would never be used directly, but used via the __()
 * function, which loads the message and replaces parameters:
 *
 *     // Display a translated message
 *     echo __('Hello, world');
 *
 *     // With parameter replacement
 *     echo __('Hello, :user', array(':user' => $username));
 *
 * @package    Kohana, arx
 * @category   Base
 * @author     Daniel Sum, Kohana Team
 * @copyright  (c) 2008-2011 Kohana Team
 * @license    http://kohanaframework.org/license
 */

include_once DIR_CLASSES.DS.'i18n'.DS.'streams'.EXT_PHP;
include_once DIR_CLASSES.DS.'i18n'.DS.'translations'.EXT_PHP;
include_once DIR_CLASSES.DS.'i18n'.DS.'po'.EXT_PHP;
include_once DIR_CLASSES.DS.'i18n'.DS.'mo'.EXT_PHP;
include_once DIR_CLASSES.DS.'i18n'.DS.'entry'.EXT_PHP;

class i18n
{
    /**
     * @var  string   target language: en-us, es-es, zh-cn, etc
     */
    public static $lang = ZE_LANG;

    /**
     * @var  string  source language: en-us, es-es, zh-cn, etc
     */
    public static $source = ZE_LANG;

    /**
     * @var  array  cache of loaded languages
     */
    protected static $_cache = array();

    /**
     * Get and set the target language.
     *
     *     // Get the current language
     *     $lang = I18n::lang();
     *
     *     // Change the current language to Spanish
     *     I18n::lang('es-es');
     *
     * @param   string   new language setting
     * @return string
     * @since   3.0.2
     */
    public static function lang($lang = NULL)
    {
        if ($lang) {
            // Normalize the language
            I18n::$lang = strtolower(str_replace(array(' ', '_'), '-', $lang));
        }

        return I18n::$lang;
    }

    /**
     * Returns translation of a string. If no translation exists, the original
     * string will be returned. No parameters are replaced.
     *
     *     $hello = I18n::get('Hello friends, my name is :name');
     *
     * @param   string   text to translate
     * @param   string   target language
     * @return string
     */
    public static function get($string, $lang = NULL)
    {
        if (! $lang) {
            // Use the global target language
            $lang = (I18n::$lang);
        }

        // Load the translation table for this language
        $table = I18n::load($lang);

        // Return the translated string if it exists
        return isset($table[$string]) ? $table[$string] : $string;
    }

    /**
     * Returns the translation table for a given language.
     *
     *     // Get all defined Spanish messages
     *     $messages = I18n::load('es-es');
     *
     * @param   string   language to load
     * @return array
     */
    public static function load($lang)
    {
        if (isset(I18n::$_cache[$lang])) {
            return I18n::$_cache[$lang];
        }

        // New translation table
        $table = array();

        if ($files = c_fm::find(DIR_ROOT . DS . I18N, $lang.'.*')) {
            $t = array();
            foreach ($files as $key=>$file) {
                switch (true) {
                    case preg_match('/.po/', $file):
                        // Merge the language strings into the sub table
                        $t = array_merge($t, self::loadPo($file));
                    break;
                    case preg_match('/.mo/',  $file):
                        // Merge the language strings into the sub table
                        $t = array_merge($t, self::loadMo($file));
                    break;
                    case preg_match('/'.EXT_PHP.'/',  $file):
                        $a = Kohana::load($file);
                        $t = array_merge($t, $a);
                    break;
                }
            }

            // Append the sub table, preventing less specific language
            // files from overloading more specific files
            $table += $t;
        }

        // Cache the translation table locally
        return I18n::$_cache[$lang] = $table;
    }

    /**
     * Loads the binary .mo file and returns array of translations
     *
     * @param  string $filename Binary .mo file to load
     * @return mixed  Array of translations on success or false on failure
     */
    public static function loadMo($filename)
    {
        $translations = false;

        // @codingStandardsIgnoreStart
        // Binary files extracted makes non-standard local variables
        if ($data = file_get_contents($filename)) {
            $translations = array();
            $header = substr($data, 0, 20);
            $header = unpack("L1magic/L1version/L1count/L1o_msg/L1o_trn", $header);
            extract($header);

            if ((dechex($magic) == '950412de' || dechex($magic) == 'ffffffff950412de') && $version == 0) {
                for ($n = 0; $n < $count; $n++) {
                    $r = unpack("L1len/L1offs", substr($data, $o_msg + $n * 8, 8));
                    $msgid = substr($data, $r["offs"], $r["len"]);
                    unset($msgid_plural);

                    if (strpos($msgid, "\000")) {
                        list($msgid, $msgid_plural) = explode("\000", $msgid);
                    }
                    $r = unpack("L1len/L1offs", substr($data, $o_trn + $n * 8, 8));
                    $msgstr = substr($data, $r["offs"], $r["len"]);

                    if (strpos($msgstr, "\000")) {
                        $msgstr = explode("\000", $msgstr);
                    }
                    $translations[$msgid] = $msgstr;

                    if (isset($msgid_plural)) {
                        $translations[$msgid_plural] =& $translations[$msgid];
                    }
                }
            }
        }
        // @codingStandardsIgnoreEnd
        return $translations;
    }

    /**
     * Loads the text .po file and returns array of translations
     *
     * @param  string $filename Text .po file to load
     * @return mixed  Array of translations on success or false on failure
     */
    public static function loadPo($filename)
    {
        if (!$file = fopen($filename, "r")) {
            return false;
        }

        $type = 0;
        $translations = array();
        $translationKey = "";
        $plural = 0;
        $header = "";

        do {
            $line = trim(fgets($file));
            if ($line == "" || $line[0] == "#") {
                continue;
            }
            if (preg_match("/msgid[[:space:]]+\"(.+)\"$/i", $line, $regs)) {
                $type = 1;
                $translationKey = stripcslashes($regs[1]);
            } elseif (preg_match("/msgid[[:space:]]+\"\"$/i", $line, $regs)) {
                $type = 2;
                $translationKey = "";
            } elseif (preg_match("/^\"(.*)\"$/i", $line, $regs) && ($type == 1 || $type == 2 || $type == 3)) {
                $type = 3;
                $translationKey .= stripcslashes($regs[1]);
            } elseif (preg_match("/msgstr[[:space:]]+\"(.+)\"$/i", $line, $regs) && ($type == 1 || $type == 3) && $translationKey) {
                $translations[$translationKey] = stripcslashes($regs[1]);
                $type = 4;
            } elseif (preg_match("/msgstr[[:space:]]+\"\"$/i", $line, $regs) && ($type == 1 || $type == 3) && $translationKey) {
                $type = 4;
                $translations[$translationKey] = "";
            } elseif (preg_match("/^\"(.*)\"$/i", $line, $regs) && $type == 4 && $translationKey) {
                $translations[$translationKey] .= stripcslashes($regs[1]);
            } elseif (preg_match("/msgid_plural[[:space:]]+\".*\"$/i", $line, $regs)) {
                $type = 6;
            } elseif (preg_match("/^\"(.*)\"$/i", $line, $regs) && $type == 6 && $translationKey) {
                $type = 6;
            } elseif (preg_match("/msgstr\[(\d+)\][[:space:]]+\"(.+)\"$/i", $line, $regs) && ($type == 6 || $type == 7) && $translationKey) {
                $plural = $regs[1];
                $translations[$translationKey][$plural] = stripcslashes($regs[2]);
                $type = 7;
            } elseif (preg_match("/msgstr\[(\d+)\][[:space:]]+\"\"$/i", $line, $regs) && ($type == 6 || $type == 7) && $translationKey) {
                $plural = $regs[1];
                $translations[$translationKey][$plural] = "";
                $type = 7;
            } elseif (preg_match("/^\"(.*)\"$/i", $line, $regs) && $type == 7 && $translationKey) {
                $translations[$translationKey][$plural] .= stripcslashes($regs[1]);
            } elseif (preg_match("/msgstr[[:space:]]+\"(.+)\"$/i", $line, $regs) && $type == 2 && !$translationKey) {
                $header .= stripcslashes($regs[1]);
                $type = 5;
            } elseif (preg_match("/msgstr[[:space:]]+\"\"$/i", $line, $regs) && !$translationKey) {
                $header = "";
                $type = 5;
            } elseif (preg_match("/^\"(.*)\"$/i", $line, $regs) && $type == 5) {
                $header .= stripcslashes($regs[1]);
            } else {
                unset($translations[$translationKey]);
                $type = 0;
                $translationKey = "";
                $plural = 0;
            }
        } while (!feof($file));
        fclose($file);

        $merge[""] = $header;

        return array_merge($merge, $translations);
    }

} // End I18n

if ( ! function_exists('_i')) {
    /**
     * Kohana translation/internationalization function. The PHP function
     * [strtr](http://php.net/strtr) is used for replacing parameters.
     *
     *    __('Welcome back, :user', array(':user' => $username));
     *
     * [!!] The target language is defined by [I18n::$lang].
     *
     * @uses    I18n::get
     * @param   string  text to translate
     * @param   array   values to replace in the translated text
     * @param   string  source language
     * @return string
     */
    function _i($string, array $values = NULL, $lang = ZE_LANG)
    {

        if ($lang !== I18n::$lang) {
            // The message and target languages are different
            // Get the translation for this message
            $string = I18n::get($string, $lang);
        }

        return empty($values) ? $string : strtr($string, $values);
    }
}
