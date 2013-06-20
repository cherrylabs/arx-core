<?php namespace Arx;

/**
 * @example:
 * $params = array(
 *    'type' => 'tab',
 *
 *    'class' => 'span4',
 *
 *    'buttons' => array(
 *        'tab-1' => array(
 *            'class' => 'active',
 *            'text' => 'Tab 1'
 *        ),
 *        'tab-2' => array(
 *            'text' => 'Tab 2'
 *        )
 *    ),
 *
 *    'content' => array(
 *        'tab-1' => 'Lorem ipsum tab 1',
 *        'tab-2' => 'Lorem ipsum tab 2'
 *    ),
 * );
 *
 * // or
 *
 * $params = array(
 *    'type' => 'collapse',
 *    'collapsed' => 'false',
 *
 *    'class' => 'span4',
 *
 *    'icon' => 'icon-dashboard',
 *    'title' => 'My dashboard',
 *    'buttons' => array(
 *        'icon-plus' => array(
 *            'class' => 'external',
 *            'href' => '#',
 *            'title' => 'New window'
 *        )
 *    ),
 *
 *    'content' => 'Lorem ipsum dolor sit amet...',
 * );
 *
 * // then
 *
 * $widget = new h_widget($params);
 *
 * echo $widget->output();
 */

class h_widget extends c_helper{

    public $output = '';

    public $template = '<div class="widget widget-bordered {{class}}">
        <div class="widget-header">
            {{{title}}}
            {{{buttons}}}
        </div>
        {{{content}}}
    </div>';

    public function __construct($data, $output = false) {
        $obj = new a_mustache();

        if (!isset($data['type']) || empty($data['type'])) {
            $data['type'] = 'basic';
        }

        switch ($data['type']) {
            case 'collapse':
                if ($data['collapsed']) {
                    $data['buttons']['icon-chevron-down'] = array(
                        'data-collapsed' => 'true',
                        'href' => '#'
                    );
                } else {
                    $data['buttons']['icon-chevron-up'] = array(
                        'data-collapsed' => 'false',
                        'href' => '#'
                    );
                }

                $tmp = '';

                foreach ($data['buttons'] as $icon => $attrs) {
                    $tmp .= '<li><a'.c_html::attributes($attrs).'><i class="'.$icon.'"></i></a></li>';
                }

                $data['buttons'] = $obj->render('<ul class="widget-buttons nav nav-pills">{{{buttons}}}</ul>', array(
                    'buttons' => $tmp
                ));

                if (isset($data['icon']) && !empty($data['icon'])) {
                    $data['title'] = '<i class="'.$data['icon'].'"></i> '.$data['title'];
                }

                $data['title'] = $obj->render('<h5>{{{title}}}</h5>', array(
                    'title' => $data['title']
                ));

                $data['content'] = '<div class="widget-body">'.$data['content'].'</div>';

                break;

            case 'tab':
                $data['title'] = '';

                $tmp = '';

                foreach ($data['buttons'] as $tab => $attrs) {
                    if (!isset($attrs['class']) || empty($attrs['class'])) {
                        $tmp .= '<li>';
                    } else {
                        $tmp .= '<li class="'.$attrs['class'].'">';
                    }

                    $tmp .= '<a href="#'.$tab.'" data-toggle="tab">';

                    if (isset($attrs['text'])) {
                        $tmp .= $attrs['text'];
                    }

                    $tmp .= '</a></li>';
                }

                $data['buttons'] = $obj->render('<ul class="nav nav-tabs">{{{buttons}}}</ul>', array(
                    'buttons' => $tmp
                ));

                $tmp = '';

                foreach ($data['content'] as $tab => $content) {
                    if (isset($data['buttons'][$tab]['class']) && preg_match('/(active)/i', $data['buttons'][$tab]['class'])) {
                        $tmp .= '<div class="tab-pane active"';
                    } else {
                        $tmp .= '<div class="tab-pane"';
                    }

                    $tmp .= ' id="'.$tab.'">'.$content.'</div>';
                }

                $data['content'] = '<div class="widget-body tab-content">'.$tmp.'</div>';

                break;

            default:
                $data['buttons'] = array();

                if (isset($data['icon']) && !empty($data['icon'])) {
                    $data['title'] = '<i class="'.$data['icon'].'"></i> '.$data['title'];
                }

                $data['title'] = $obj->render('<h5>{{{title}}}</h5>', array(
                    'title' => $data['title']
                ));

                $data['content'] = '<div class="widget-body">'.$data['content'].'</div>';
        }


        pre($data);

        $this->output = $obj->render($this->template, $data);

        if ($output) {
            return $this->output;
        }
    } // __construct

    public function output() {
        return $this->output;
    }


}
