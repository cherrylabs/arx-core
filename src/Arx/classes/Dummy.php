<?php namespace Arx\classes;

/**
 * Class Dummy
 *
 * Very simple dummy text, image, video, title generator
 *
 * @package Arx\classes
 */
class Dummy
{

    /**
     * Generate a dummy image link
     *
     * @param string $mixSize
     * @param string $background
     * @param string $foregroundColor
     * @param null $text
     * @param string $format
     * @return string
     */
    public static function image($mixSize = '400x350', $background = '000', $foregroundColor = 'fff', $text = null, $format = 'jpg')
    {
        return "//dummyimage.com/$mixSize/$background/$foregroundColor" . (!$text ? : '&text=' . urlencode($text));
    }

    /**
     * Generate a dummy text
     *
     * @param array $param
     * @return string
     */
    public static function text($param = array())
    {

        $defParam = array(
            'amount' => 128,
            'what' => 'bytes',
            'start' => 'yes',
            'lang' => 'en'
        );

        if (is_integer($param)) {
            $param = array('amount' => $param);
        }

        $param = array_merge($defParam, $param);

        $json = Utils::getJSON('http://json-lipsum.appspot.com/?' . http_build_query($param));

        if (isset($json->lipsum) && strpos('--', $json->lipsum)) {
            return implode(' -- ', $json->lipsum);
        } elseif (isset($json->lipsum)) {
            return $json->lipsum;
        } else {
            return 'Error Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        }

    }

    /**
     * Generate a dummy title
     *
     * @param null $param
     * @return string
     */
    public static function title($param = null)
    {

        if (is_integer($param)) {
            $param = array(
                'amount' => $param
            );
        }

        if (!is_array($param)) {
            $param = array();
        }

        $defParam = array(
            'amount' => 30,
            'what' => 'bytes',
            'start' => 'yes',
            'lang' => 'en'
        );

        $param = array_merge($defParam, $param);

        $json = Utils::getJSON('http://json-lipsum.appspot.com/?' . http_build_query($param));

        if (isset($json->lipsum)) {
            return $json->lipsum;
        } else {
            return 'Error Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        }

    }

    /**
     * Generate a Youtube video iframe
     *
     * @param null $mixWidth
     * @param null $height
     * @return string
     */
    public static function video($mixWidth = null, $height = null)
    {

        $defParam = array(
            'width' => 560,
            'height' => 315,
            'src' => '//www.youtube.com/embed/0af00UcTO-c',
            'frameborder' => 0,
            'allowfullscreen' => 'true'
        );

        $param = array();

        if (is_integer($mixWidth)) {
            $param['width'] = $mixWidth;
        }

        if (!$height && is_integer($height)) {
            $param['height'] = $height;
        }

        $param = array_merge($defParam, $param);

        return '<iframe ' . Html::attributes($param) . '></iframe>';

    }

	/**
	 * Generate random email
	 *
	 * @return string
	 */
	public static function email(){
		return Utils::randEmail();
	}

}