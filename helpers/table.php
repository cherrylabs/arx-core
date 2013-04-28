<?php
/**
 * h_table - Generate a Twitter Bootstrap Table
 *
 * @use
 * $this->h_table(array $data[, array $format[, bool $output]]);
 * 
 * @author Stéphan Zych <stephan@cherrypulp.com>
 * @link http://www.cherrylabs.net
 * @copyright Copyright &copy; 2010-2012 cherrylabs.net
 * @license http://www.cherrylabs.net/licence
 * @package arx
 * @since 1.0
 */

// @example
// echo $this->h_table(array(
// 	array(
// 		'id' => 0,
// 		'lastname' => 'Doe',
// 		'firstname' => 'John'
// 	),
// 	array(
// 		'id' => 1,
// 		'lastname' => 'Doe',
// 		'firstname' => 'Jean',
// 		'attr' => array(
// 			'class' => 'success'
// 		)
// 	)
// ), array(
// 	'caption' => 'A simple table',
// 	'thead' => array(
// 		'id' => array(
// 			'name' => 'Id'
// 		),
// 		'lastname' => array(
// 			'name' => 'Last name'
// 		),
// 		'firstname' => array(
// 			'name' => 'First name'
// 		),
// 		'action' => array(
// 			'name' => 'Action',
// 			'attr' => array(
// 				'class' => 'action'
// 			)
// 		)
// 	),
// 	'attr' => array(
// 		'class' => 'table table-condensed table-hover table-bordered',
// 		'data' => array(
// 			'test' => 'some value'
// 		)
// 	),
// ));

// @return
// <table class="table table-condensed table-hover table-bordered" data-test="some value">
// 	<caption>A simple table</caption>
	
// 	<thead>
// 		<tr>
// 			<th>Id</th>
// 			<th>Lastname</th>
// 			<th>Firstname</th>
// 			<th>Action</th>
// 		</tr>
// 	</thead>

// 	<tbody>
// 		<tr>
// 			<td>0</td>
// 			<td>Doe</td>
// 			<td>John</td>
// 			<td class="action"></td>
// 		</tr>
// 		<tr class="success">
// 			<td>1</td>
// 			<td>Doe</td>
// 			<td>Jean</td>
// 			<td class="action"></td>
// 		</tr>
// 	</tbody>
// </table>


class h_table {

	public function __construct() {
		$iArgs = func_num_args();
        $aArgs = func_get_args();

        if ($iArgs < 1 || empty($aArgs[0])) {
        	return '';
        }

        $bOutput = false;

        switch ($iArgs) {
            case 2:
                list($aData, $aFormat) = $aArgs;

                if (is_bool($aFormat)) {
                    $bOutput = $aFormat;
                    unset($aFormat);
                }

                break;

            case 3:
                list($aData, $aFormat, $bOutput) = $aArgs;
                break;
            
            default:
                $aData = $aArgs[0];
        }

        $output = '<table';

        if (isset($aFormat) && !empty($aFormat['attr'])) {
        	$output .= ' '.HTML::attributes($aFormat['attr']);
        }

        $output .= '>';

        if (isset($aFormat) && isset($aFormat['caption'])) {
        	$output .= '<caption>'.$aFormat['caption'].'</caption>';
        }

        $output .= '<thead><tr>';

        if (isset($aFormat) && isset($aFormat['thead'])) {
	        foreach ($aFormat['thead'] as $key => $head) {
	        	$output .= '<td';

	        	if (isset($head['attr'])) {
	        		$output .= ' '.HTML::attributes($head['attr']);
	        	}

	        	$output .= '>'.$head['name'].'</td>';
	        }
	    } else {
	    	foreach ($aData as $key => $head) {
	    		$output .= '<td>'.$key.'</td>';
	    	}
	    }

        $output .= '</tr></thead>';

        $output .= '<tbody>';

        foreach ($aData as $key => $row) {
        	$output .= '<tr';

        	if (isset($row['attr'])) {
        		$output .= ' '.HTML::attributes($row['attr']);
        	}

        	$output .= '>';

        	if (isset($aFormat) && isset($aFormat['thead'])) {
	        	foreach ($aFormat['thead'] as $k => $format) {
	        		if ($k !== 'attr') {
	        			$output .= '<td';

	        			if (isset($format['attr'])) {
		        			$output .= ' '.HTML::attributes($aFormat['thead'][$k]['attr']);
		        		}

		        		$output .= '>';

		        		if (isset($row[$k])) {
		        			$output .= $row[$k];
		        		}

		        		$output .= '</td>';
	        		}
	        	}
	        } else {
	        	foreach ($row as $k => $data) {
	        		if ($k !== 'attr') {
		        		$output .= '<td';

		        		if (isset($aFormat) && isset($aFormat['thead']) && isset($aFormat['thead'][$k]) && isset($aFormat['thead'][$k]['attr'])) {
		        			$output .= ' '.HTML::attributes($aFormat['thead'][$k]['attr']);
		        		}

		        		$output .= '>'.$data.'</td>';
		        	}
	        	}
	        }

        	$output .= '</tr>';
        }

        $output .= '</tbody></table>';

        if ($bOutput) {
            echo $output;
        }
        
        return $output;
	} // __construct

} // helper:h_table


