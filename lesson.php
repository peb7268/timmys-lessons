<?php
/*
$fruits=array('apples', 'oranges', 'melons', 'plums');
foreach ($fruits as $fruit){
	echo '<p>It\'s my favorite $fruit</p>';
}
*/

/* associative & multidimensional array
$fruits = array(	'apples' 	=> array('white', 'orange', 'red'),
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
*/

class Fruit {
	public $type;
	public $color;
	public $name;

	public function __construct($name, $type, $color){
		$this->name 	= $name;
		$this->type 	= $type;
		$this->color 	= $color;

		echo "Im a $type $name with a $color color <br>";
	}
}

$orange = new Fruit('Orange', 'citrus fruit', 'yellow');

echo "The color of the orange is: ". $orange->color;