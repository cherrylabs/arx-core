<?php namespace Arx;

/**

$html = zencode('div>ul>li>p["text"]+p["text two"]');

$var = array('test' => array('hello', 'world'));
$html = zencode('div>ul>li>p["{test[$]}"]*2', $var);

$html = zencode('a#test.thisclass.otherclass[ref="{test[0]}"]["content text "]>ul>li#$[href="{test[$]}link"]*2', $var);



function myfunc1($str)
{
return ucfirst($str);
}
function myfunc2($index)
{
return 'This '.$index;
}
$var = array('a_function1'=>'myfunc1','a_function2'=>'myfunc2');
$html = zencode('div["{a_function1("test")}+div["{a_function2($)}"]*3',$var);

$var = array('test' => array('hello', 'world'));

$html = zencode('div["{=  return $test[0] . " - ". $test[1]; }"]',$var);



$html = zencode('div["{=  $x = $test[0]; $y = $test[1]; return $x . " - " . $y; }"]',$var);
 */

class c_zencode {

    /**
     *
     */
    public function _replace($matches) {
        global $var_data_zen, $var_index_zen;
        $match = $matches[1];
        foreach ($var_data_zen as $key => $value) {
            $$key = $value;
        }

        $match = str_replace('$', $var_index_zen, $match);

        eval("\$data = $" . $match . ";");

        return $data;
    }

    /**
     *
     * @global type $var_data_zen
     * @global type $var_index_zen
     * @param type $matches
     * @return type
     */
    public function _replace_code($matches) {
        global $var_data_zen, $var_index_zen;
        $match = $matches[1];

        foreach ($var_data_zen as $key => $value) {
            $$key = $value;
        }

        $index = $var_index_zen;
        $data = eval($match);

        return $data;
    }

    /**
     *
     * @global type $var_data_zen
     * @global type $var_index_zen
     * @param type $html
     * @param type $index
     * @param type $var
     * @return type
     */
    public function _replace_var($html, $index, $var) {
        global $var_data_zen, $var_index_zen;

        $pattern = '/{([\w$\[\]"()]+?)}/i'; // Matches any template tag
        $callback = "_replace";
        $var_data_zen = $var;
        $var_index_zen = $index;

        $html = preg_replace_callback($pattern, array(&$this, $callback), $html);

        $pattern = '/{=(.*)}/i'; // Matches any template tag
        $callback = "_replace_code";

        $html = preg_replace_callback($pattern, array(&$this, $callback), $html);

        $html = preg_replace('/\$/', $index, $html);
        return $html;
    }

    /**
     *
     * @param type $code
     * @param type $index
     * @param type $var
     * @return type
     */
    public function _parse($code, $index, $var) {

        $t = 'dom';
        $c = $code[$index];
        $dom = $c['data'];
        $data = array();
        $i = 0;
        $v = '';
        $content = '';
        while ($i < strlen($dom)) {
            if ($dom[$i] == '.') {

                $data[$t][] = $v;
                $t = 'class';
                $v = '';
            } elseif ($dom[$i] == '#') {
                $data[$t][] = $v;
                $t = 'id';

                $v = '';
            } elseif ($dom[$i] == '[') {
                $data[$t][] = $v;
                $t = 'params';
                $v = '';
            } elseif ($dom[$i] == ']') {
                $data[$t][] = $v;
                $t = 'E';
                $v = '';
            } elseif ($dom[$i] == '{') {
                while ($dom[$i] <> '}') {
                    $v = $v . $dom[$i++];
                }
                $v = $v . $dom[$i];
            } elseif ($dom[$i] == '*') {
                $data[$t][] = $v;
                $t = 'times';
                $v = '';
            }
            else
                $v = $v . $dom[$i];
            $i++;
        }

        $data[$t][] = $v;
        $times = 1;
        if (isset($data['times'][0]))
            $times = $data['times'][0];
        $rot = 0;
        $html = '';
        while ($rot < $times) {


            $subhtml = '<' . $data['dom'][0];
            if (isset($data['id']))
                $subhtml .= ' id="' . $data['id'][0] . '"';
            if (isset($data['class'])) {
                $d = '';
                foreach ($data['class'] as $cl) {
                    $d .= ' ' . $cl;
                }
                $subhtml .= ' class="' . trim($d) . '"';
            }
            if (isset($data['params'])) {
                foreach ($data['params'] as $pr) {
                    if (preg_match('/(.*)="(.*)"$/', $pr))
                        $subhtml .= ' ' . trim($pr);
                    else
                        $content = ' ' . trim($pr, '"');
                }
            }

            $subhtml .= '>' . $content;
            if ((isset($code[$index + 1]['type'])) and ($code[$index + 1]['type'] == '>'))
                $subhtml .= $this->_parse($code, $index + 1, $var);
            $subhtml .= '</' . $data['dom'][0] . '>';
            $subhtml = $this->_replace_var($subhtml, $rot, $var);
            $html .= $subhtml;
            $rot++;
        }
        if ((isset($code[$index + 1]['type'])) and ($code[$index + 1]['type'] == '+'))
            $html .= $this->_parse($code, $index + 1, $var);

        return $html;
    }

    /**
     *
     * @param type $code
     * @param type $var
     * @return type
     */
    public function render($code, $var = array()) {

        $zen = new self();

        $code = explode('>', $code);
        $domarray = array();
        foreach ($code as $item) {
            $sub = explode('+', $item);
            foreach ($sub as $key => $s)
                $domarray[] = array('type' => ($key ? '+' : '>'), 'data' => $s);
        }

        $html = $zen->_parse($domarray, 0, $var);
        return trim($html);
    }

}