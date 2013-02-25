<?php

echo '<ul class="dropdown-menu">';

foreach($this->dropdown as $key => $value) {
	echo '<li><a';
	
	foreach($value['attributes'] as $k => $v) {
		echo ' ' . $k . '="' . $v .'"';
	}
	
	echo '>' . $value['content'] . '</a></li>';
}

echo '</ul><!--/.dropdown-menu -->';
