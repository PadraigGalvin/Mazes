<?php

// dimensions (10px cells)
$width = 50;
$height = 50;

$logs = array(); // for debugging
$grid = array(); // 
$stack = array(); // keep track of visited cells

// set up the grid with borders on all sides
for ($row = 0; $row < $height; $row++) {
	$grid[$row] = array();
	for ($col = 0; $col < $width; $col++) {
		$grid[$row][$col] = array();
	}
}

// pick random starting position
$position = array(
	rand(0, $height - 1), 
	rand(0, $width - 1)
);

// add inital position to stack
$stack[] = $position;

// keep going until stack is empty
while (!empty($stack)) {

	$logs[] = "position: " . $position[0] . ", " . $position[1];
	$possible = array(); // possible directons to create path

	// check if neighbouring cells exist and have not been visited
	if ($position[0] > 0 && empty($grid[$position[0]-1][$position[1]])) {
		$possible[] = 'N';
	}
	if ($position[1] < $width - 1 && empty($grid[$position[0]][$position[1]+1])) {
		$possible[] = 'E';
	}
	if ($position[0] < $height - 1 && empty($grid[$position[0]+1][$position[1]])) {
		$possible[] = 'S';
	}
	if ($position[1] > 0 && empty($grid[$position[0]][$position[1]-1])) {
		$possible[] = 'W';
	}

	if (!empty($possible)) {

		// randomly pick a directon to go next
		$dir = $possible[array_rand($possible)];
		$logs[] = "go " . $dir;
		$next = $position;

		// set the next position and update the grid
		if ($dir == 'N') {
			$next[0]--;
			$grid[$position[0]][$position[1]][] = 'N';
			$grid[$next[0]][$next[1]][] = 'S';
		} else if ($dir == 'E') {
			$next[1]++;
			$grid[$position[0]][$position[1]][] = 'E';
			$grid[$next[0]][$next[1]][] = 'W';
		} else if ($dir == 'S') {
			$next[0]++;
			$grid[$position[0]][$position[1]][] = 'S';
			$grid[$next[0]][$next[1]][] = 'N';
		} else if ($dir == 'W') {
			$next[1]--;
			$grid[$position[0]][$position[1]][] = 'W';
			$grid[$next[0]][$next[1]][] = 'E';
		}

		$position = $next; // update current position ...
		$stack[] = $position; // ... and it to the stack

	} else {

		// nowhere to go? remove the cell from the stack and take a step back
		$position = array_pop($stack); 
		$logs[] = "dead end";

	}
}

?>
<!DOCTYPE html>
<html>

	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<title>Recursive Backtracking Algorithm</title>
		<style type="text/css">
body {
	background: #EEE;
	text-align: center;
	font-family: sans-serif;
	color: #333;
}
#maze {
	border: 1px solid #555;
	background: #FFF;
	font-size: 0;
	box-shadow: 0 0 10px #AAA;
	width: <?php echo $height * 12; ?>px;
	margin: 25px auto;
}
.cell {
	width: 10px;
	height: 10px;
	border: 1px solid #555;
	display: inline-block;
}
.N {
	border-top-color: #EEE;
}
.E {
	border-right-color: #EEE;
}
.S {
	border-bottom-color: #EEE;
}
.W {
	border-left-color: #EEE;
}
		</style>
	</head>
	
	<body>
		<h1>Perfect maze generator.</h1>
		<p><i>
			Built using a PHP recursive backtracking algorithm. Code available on 
			<a href="https://github.com/xgalvin/Mazes">GitHub</a>.
		</i></p>
		<div id="maze">
			<?php foreach ($grid as $row): ?>
			<div class="row">
				<?php foreach ($row as $cell): ?>
				<?php
				$class = "";
				foreach ($cell as $path) {
					$class .= " ".$path;
				}
				?>
				<div class="cell<?php echo $class; ?>"></div>
				<?php endforeach; ?>
			</div>
			<?php endforeach; ?>
		</div>
	<!--	<div class="log">
			<?php foreach($logs as $log): ?>
				<?php echo $log; ?><br>
			<?php endforeach; ?>
		</div> -->
	</body>

</html>
