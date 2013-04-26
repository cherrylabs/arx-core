<?php
/**
 * h_dropdown - Generate a Twitter Bootstrap Dropdown
 *
 * @author Stéphan Zych <stephan@cherrypulp.com>
 * @link http://www.cherrylabs.net
 * @copyright Copyright &copy; 2010-2012 cherrylabs.net
 * @license http://www.cherrylabs.net/licence
 * @package arx
 * @since 1.0
 */

// echo $this->h_dropdown(array(
//     array(
//         'name' => 'First menu',
//         'href' => 'http://domain.tld',
//         'attr' => array(
//             'class' => 'active',
//             'data' => array(
//                 'test' => 'some value'
//             )
//         )
//     ),
//     array(
//         'name' => 'Second with sub',
//         'children' => array(
//             array(),
//             array(),
//         )
//     )
// ), 'My dropdown');

// <div class="dropdown">
//      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Dropdown trigger</a>
//      
//      <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
//            ...
//          <li><a href="#">Another action</a></li>
//          <li class="dropdown-submenu">
//              <a href="#">More options <b class="caret"></b></a>
//              
//              <ul class="dropdown-menu">
//                ...
//              </ul>
//          </li>
//      </ul>
// </div>


class h_dropdown {

    public function __construct() {
        $iArgs = func_num_args();
        $aArgs = func_get_args();

        if (empty($aArgs) || empty($aArgs[0])) {
            return '';
        }

        switch ($iArgs) {
            case 2:
                list($aMenu, $sTrigger) = $aArgs;

                if (is_bool($sTrigger)) {
                    $bOutput = $sTrigger;
                    unset($sTrigger);
                }

                break;

            case 3:
                list($aMenu, $sTrigger, $bOutput) = $aArgs;
                break;
            
            default:
                $aMenu = $aArgs[0];
        }

        $output = '';

        if (isset($sTrigger)) {
            $output .= '<a class="dropdown-toggle" data-toggle="dropdown" href="#">'.$sTrigger.'</a>';
        }

        $output .= '<ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">';

        foreach ($aMenu as $key => $menu) {
            $output .= '<li';

            if (isset($menu['children'])) {
                $output .= ' class="dropdown-submenu"';
            }

            if (isset($menu['href'])) {
                $output .= '><a href="'.$menu['href'].'"';
            } else {
                $output .= '><a href="#"';
            }

            if (isset($menu['attr'])) {
                $output .= ' '.HTML::attributes($menu['attr']);
            }

            $output .= '>'.$menu['name'].'</a>';

            if (isset($menu['children']) && !empty($menu['children'])) {
                $output .= '<ul class="dropdown-menu">';

                foreach ($menu['children'] as $k => $submenu) {
                    $output .= '<li>';

                    if (isset($submenu['href'])) {
                        $output .= '<a href="'.$submenu['href'].'"';
                    } else {
                        $output .= '<a href="#"';
                    }

                    if (isset($submenu['attr'])) {
                        $output .= ' '.HTML::attributes($submenu['attr']);
                    }
                    
                    $output .= '>'.$submenu['name'].'</a></li>';
                }

                $output .= '</ul>';
            }

            $output .= '</li>';
        }

        $output .= '</ul>';

        $output = '<div class="dropdown">'.$output.'</div>';

        if ($bOuput) {
            echo $output;
        }
        
        return $output;

    } // __construct

} // class:h_dropdown