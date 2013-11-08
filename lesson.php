<?php
/*
$fruits=array('apples', 'oranges', 'melons', 'plums');
foreach ($fruits as $fruit){
	echo '<p>It\'s my favorite $fruit</p>';
}
*/
$fruits=array(	'apples' 	=> array('white', 'orange', 'red'),
				'oranges' 	=> 'pink',
	 			'melons'	=> 'yellow',
	 			'plums'		=> 'red'
	 			);
foreach ($fruits as $key => $value) {

	$s = "<p>$key ";

	if (gettype($value) == 'array'){
		foreach ($value as $color) {
		 $s .= "$color ";
		}
	}

	if(gettype($value) != 'array') $s .= "$value";

	echo $s."</p>";
}