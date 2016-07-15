<?php
	$number = 1;
	while ($number <= 100){
		if ($number % 3 == 0 && $number % 5 == 0){
			echo "foobar, ";
		}
		elseif ($number % 3 == 0)  {
			echo "foo, ";
		} elseif ($number % 5 == 0) {
			echo "bar, ";
		}else{
		echo $number.", ";}

		$number++;
	}
?>