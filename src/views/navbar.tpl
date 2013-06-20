<?php

if(isset($this->navbar['menu']))
{

	$tmp_container = false;
	
	if( isset($this->navbar['config']['class']) )
		echo '<div class="navbar ' . $this->navbar['config']['class'] .'">';
	else
		echo '<div class="navbar">';
	
	echo '<div class="navbar-inner">';
	
	if( isset($this->navbar['config']['container']) &&  isset($this->navbar['config']['container']) === true  ){
		$tmp_container = true;
		echo '<div class="container">';
	}
	
	if( isset($this->navbar['brand']) )
		echo '<a class="brand' . (isset($this->navbar['brand']['attributes']) && isset($this->navbar['brand']['attributes']['class'])) . '">' . $this->navbar['brand']['content'] . '</a><!--/.brand -->';
	
	echo '<ul class="nav">';
	foreach($this->navbar['menu'] as $key => $value) {
		$tmp_dropdown = false;
		
		if( array_key_exists('child', $value) ) {
			$tmp_dropdown = true;
			
			echo '<li class="dropdown"><a';
			
			foreach($value['attributes'] as $k => $v) {
				if( array_key_exists('class', $value['attributes']) )
					echo ' class="dropdown-toggle ' . $v . '" data-toggle="dropdown"';
				elseif( !array_key_exists('class', $value['attributes']) )
					echo ' class="dropdown-toggle" data-toggle="dropdown"';
				
				echo ' ' . $k . '="' . $v . '"';
			}
			
			echo '>' . $value['content'] . '</a><!--/.dropdown-toggle -->';
			
			$this->dropdown = $value['child'];
			echo $this->fetch('views/helpers/dropdown.php');
			
			echo '</li><!--/.dropdown -->';
		} else {
			echo '<li><a';
			
			foreach($value['attributes'] as $k => $v) {
				echo ' ' . $k . '="' . $v . '"';
			}
			
			echo '>' . $value['content'] . '</a>';
			echo '</li>';
		}
		
	}
	echo '</ul><!--/.nav -->';
	
	if( $tmp_container === true  )
		echo '</div><!--/.container -->';
	
	echo '</div><!--/.navbar-inner -->';
	echo '</div><!--/.navbar -->';

}
