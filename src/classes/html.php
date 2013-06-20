<?php namespace Arx;

class c_HTML
{

    static $charset = 'utf-8';


    public static $attribute_order = array
    (
        'action',
        'method',
        'type',
        'id',
        'name',
        'value',
        'href',
        'src',
        'width',
        'height',
        'cols',
        'rows',
        'size',
        'maxlength',
        'rel',
        'media',
        'accept-charset',
        'accept',
        'tabindex',
        'accesskey',
        'alt',
        'title',
        'class',
        'style',
        'selected',
        'checked',
        'readonly',
        'disabled',
    );

    public static function link($url, $mOpts = null, $attr = array())
    {

        $name = is_string($mOpts) ? $mOpts : isset($mOpts['label']) ? $mOpts['label'] : $url;

        return '<a href="' . $url . '"' . self::attributes($attr) . '>' . $name . '</a>';
    }

    public function ulist($aArray, $ulAttributes = array(), $liAttributes = array())
    {
        $msg .= '<ul ' . self::attributes($ulAttributes) . '>';
        foreach ($aArray as $key => $value) {
            $msg .= '<li ' . self::attributes($liAttributes) . '>' . $value . '</li>';
        }
        $msg .= '</ul>';
        return $msg;
    }

    public function olist($aArray, $ulAttributes = array(), $liAttributes = array())
    {
        $msg .= '<ol ' . self::attributes($ulAttributes) . '>';
        foreach ($aArray as $key => $value) {
            $msg .= '<li ' . self::attributes($liAttributes) . '>' . $value . '</li>';
        }
        $msg .= '</ol>';
        return $msg;
    }


    public static function ul($mVars, $tpl = '<ul><li></li></ul>')
    {

        $_odd = 'odd';
        $_even = 'even';
        $_first = 'first';
        $_last = 'last';
        $_nbprefix = 'n-';

        $_iLiStart = strpos($tpl, '<li');
        $_iLiEnd = strrpos($tpl, '</li>') + 1;

        $_s = substr($tpl, 0, $_iLiStart);

        $_sLi = substr($tpl, $_iLiStart, $_iLiEnd);

        $dynVars = self::getParams($_sLi);

        $key = 0;
        $nb = 1;

        $last = count($mVars) - 1;

        $aLis = array();

        foreach ($mVars as $v) {

            $v['$key'] = $key;
            $v['$number'] = $nb;
            $v['$bool'] = ($key & 1 ? $_odd : $_even);
            $v['$position'] = ($key == 0 ? $_first : ($key != $last ? $_nbprefix . $key : 'last'));

            $aV = array();

            foreach ($dynVars[1] as $d) {
                $aV[$d] = $v[$d];
            }

            $_s .= str_replace($dynVars[0], $aV, $_sLi);

            $key++;
            $nb++;

        }

        $_s .= substr($tpl, $_iLiEnd + 4);

        return $_s;
    }

    public static function getVars($mVars, $dynVars)
    {
        ob_start();

        foreach ($mVars as $v) {

            $v['$key'] = $key;
            $v['$number'] = $nb;
            $v['$bool'] = ($key & 1 ? $_odd : $_even);
            $v['$position'] = ($key == 0 ? $_first : ($key != $last ? $_nbprefix . $key : 'last'));

            $aV = array();

            foreach ($dynVars[1] as $d) {
                $aV[$d] = $v[$d];
            }
            $_s .= str_replace($dynVars[0], $aV, $_sLi);

            $key++;
            $nb++;

        }

        ob_end_flush();

        return $_s;
    }

    public static function css()
    {
        call_user_func_array('self::style', func_get_args());
    }


    public static function getObject($str = string)
    {
        return str_get_html($str);
    }

    public static function getParams($structure)
    {
        preg_match_all("/\{(.*?)}/", $structure, $out);

        return $out;
    }

    /**
     * @var  boolean  automatically target external URLs to a new window?
     */
    public static $windowed_urls = FALSE;

    /**
     * Convert special characters to HTML entities. All untrusted content
     * should be passed through this method to prevent XSS injections.
     *
     *     echo HTML::chars($username);
     *
     * @param   string   string to convert
     * @param   boolean  encode existing entities
     * @return string
     */
    public static function chars($value, $double_encode = TRUE)
    {
        return htmlspecialchars((string)$value, ENT_QUOTES, self::$charset, $double_encode);
    }

    /**
     * Convert all applicable characters to HTML entities. All characters
     * that cannot be represented in HTML with the current character set
     * will be converted to entities.
     *
     *     echo HTML::entities($username);
     *
     * @param   string   string to convert
     * @param   boolean  encode existing entities
     * @return string
     */
    public static function entities($value, $double_encode = TRUE)
    {
        return htmlentities((string)$value, ENT_QUOTES, self::$charset, $double_encode);
    }

    /**
     * Create HTML link anchors. Note that the title is not escaped, to allow
     * HTML elements within links (images, etc).
     *
     *     echo HTML::anchor('/user/profile', 'My Profile');
     *
     * @param   string   URL or URI string
     * @param   string   link text
     * @param   array    HTML anchor attributes
     * @param   mixed    protocol to pass to URL::base()
     * @param   boolean  include the index page
     * @return string
     * @uses    URL::base
     * @uses    URL::site
     * @uses    HTML::attributes
     */
    public static function anchor($uri, $title = NULL, array $attributes = NULL, $protocol = NULL, $index = TRUE)
    {
        if ($title === NULL) {
            // Use the URI as the title
            $title = $uri;
        }

        if ($uri === '') {
            // Only use the base URL
            $uri = URL::base($protocol, $index);
        } else {
            if (strpos($uri, '://') !== FALSE) {
                if (HTML::$windowed_urls === TRUE AND empty($attributes['target'])) {
                    // Make the link open in a new window
                    $attributes['target'] = '_blank';
                }
            } elseif ($uri[0] !== '#') {
                // Make the URI absolute for non-id anchors
                $uri = URL::site($uri, $protocol, $index);
            }
        }

        // Add the sanitized link to the attributes
        $attributes['href'] = $uri;

        return '<a' . HTML::attributes($attributes) . '>' . $title . '</a>';
    }

    /**
     * Creates an HTML anchor to a file. Note that the title is not escaped,
     * to allow HTML elements within links (images, etc).
     *
     *     echo HTML::file_anchor('media/doc/user_guide.pdf', 'User Guide');
     *
     * @param   string  name of file to link to
     * @param   string  link text
     * @param   array   HTML anchor attributes
     * @param   mixed    protocol to pass to URL::base()
     * @param   boolean  include the index page
     * @return string
     * @uses    URL::base
     * @uses    HTML::attributes
     */
    public static function file_anchor($file, $title = NULL, array $attributes = NULL, $protocol = NULL, $index = FALSE)
    {
        if ($title === NULL) {
            // Use the file name as the title
            $title = basename($file);
        }

        // Add the file link to the attributes
        $attributes['href'] = URL::base($protocol, $index) . $file;

        return '<a' . HTML::attributes($attributes) . '>' . $title . '</a>';
    }

    /**
     * Creates an email (mailto:) anchor. Note that the title is not escaped,
     * to allow HTML elements within links (images, etc).
     *
     *     echo HTML::mailto($address);
     *
     * @param   string  email address to send to
     * @param   string  link text
     * @param   array   HTML anchor attributes
     * @return string
     * @uses    HTML::attributes
     */
    public static function mailto($email, $title = NULL, array $attributes = NULL)
    {
        if ($title === NULL) {
            // Use the email address as the title
            $title = $email;
        }

        return '<a href="&#109;&#097;&#105;&#108;&#116;&#111;&#058;' . $email . '"' . HTML::attributes($attributes) . '>' . $title . '</a>';
    }

    /**
     * Creates a style sheet link element.
     *
     *     echo HTML::style('media/css/screen.css');
     *
     * @param   string   file name
     * @param   array    default attributes
     * @param   mixed    protocol to pass to URL::base()
     * @param   boolean  include the index page
     * @return string
     * @uses    URL::base
     * @uses    HTML::attributes
     */
    public static function style($file, array $attributes = NULL, $protocol = NULL, $index = FALSE)
    {
        if (strpos($file, '://') === FALSE) {
            // Add the base URL
            $file = URL::base($protocol, $index) . $file;
        }

        // Set the stylesheet link
        $attributes['href'] = $file;

        // Set the stylesheet rel
        $attributes['rel'] = 'stylesheet';

        // Set the stylesheet type
        $attributes['type'] = 'text/css';

        return '<link' . HTML::attributes($attributes) . ' />';
    }

    /**
     * Creates a script link.
     *
     *     echo HTML::script('media/js/jquery.min.js');
     *
     * @param   string   file name
     * @param   array    default attributes
     * @param   mixed    protocol to pass to URL::base()
     * @param   boolean  include the index page
     * @return string
     * @uses    URL::base
     * @uses    HTML::attributes
     */
    public static function script($file, array $attributes = NULL, $protocol = NULL, $index = FALSE)
    {
        if (strpos($file, '://') === FALSE) {
            // Add the base URL
            $file = URL::base($protocol, $index) . $file;
        }

        // Set the script link
        $attributes['src'] = $file;

        // Set the script type
        $attributes['type'] = 'text/javascript';

        return '<script' . HTML::attributes($attributes) . '></script>';
    }

    /**
     * Creates a image link.
     *
     *     echo HTML::image('media/img/logo.png', array('alt' => 'My Company'));
     *
     * @param   string   file name
     * @param   array    default attributes
     * @param   mixed    protocol to pass to URL::base()
     * @param   boolean  include the index page
     * @return string
     * @uses    URL::base
     * @uses    HTML::attributes
     */
    public static function image($file, array $attributes = NULL, $protocol = NULL, $index = FALSE)
    {
        if (strpos($file, '://') === FALSE) {
            // Add the base URL
            $file = URL::base($protocol, $index) . $file;
        }

        // Add the image link
        $attributes['src'] = $file;

        return '<img' . HTML::attributes($attributes) . ' />';
    }

    /**
     * Compiles an array of HTML attributes into an attribute string.
     * Attributes will be sorted using HTML::$attribute_order for consistency.
     *
     *     echo '<div'.HTML::attributes($attrs).'>'.$content.'</div>';
     *
     * @param   array   attribute list
     * @return string
     */
    public static function attributes(array $attributes = NULL)
    {
        if (empty($attributes))
            return '';

        $sorted = array();
        foreach (self::$attribute_order as $key) {
            if (isset($attributes[$key])) {
                // Add the attribute to the sorted list
                $sorted[$key] = $attributes[$key];
            }
        }

        // Combine the sorted attributes
        $attributes = $sorted + $attributes;

        $compiled = '';
        foreach ($attributes as $key => $value) {
            if ($value === NULL) {
                // Skip attributes that have NULL values
                continue;
            }

            if (is_int($key)) {
                // Assume non-associative keys are mirrored attributes
                $key = $value;
            }

            // Add the attribute value
            $compiled .= ' ' . $key . '="' . c_html::chars($value) . '"';
        }

        return $compiled;
    }

}
