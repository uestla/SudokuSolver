<?php

require_once __DIR__ . '/../Sudoku.php';


if (!isset($_GET['values'])) {
	die();
}


$values = array();
$raw = $_GET['values'];

for ($i = 0; $i < Sudoku::SIZE; $i++) {
	for ($j = 0; $j < Sudoku::SIZE; $j++) {
		if (!isset($raw[$i][$j]) || !$raw[$i][$j]) {
			$values[$i][$j] = NULL;

		} else {
			$values[$i][$j] = max(1, min(9, (int) $raw[$i][$j]));
		}
	}
}


try {
	$sudoku = new Sudoku($values);
	if (!$sudoku->solve()) {
		echo 'error 1';

	} else {
		$solution = $sudoku->getValues();

		for ($i = 0; $i < Sudoku::SIZE; $i++) {
			echo implode('', $solution[$i]);
		}
	}

} catch (InvalidBoardValuesException $e) {
	echo 'error 2';

} catch (\Exception $e) {
	echo 'error 0';
}

die();
