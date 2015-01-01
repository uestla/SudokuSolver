<?php


class Sudoku
{

	/** @var array */
	private $values;


	const SIZE = 9;


	/** @param  array $values */
	function __construct(array $values)
	{
		$this->values = $values;
		$this->validate();
	}


	/** @return void */
	function solve()
	{
		$coords = $this->findEmptyField();

		if ($coords === NULL) {
			return TRUE;
		}

		list ($x, $y) = $coords;

		for ($i = 1; $i <= self::SIZE; $i++) {
			if ($this->canBePlaced($x, $y, $i)) {
				$this->values[$x][$y] = $i;

				if ($this->solve()) {
					return TRUE;
				}

				$this->values[$x][$y] = NULL;
			}
		}

		return FALSE;
	}


	/** @return array */
	function getValues()
	{
		return $this->values;
	}


	/** @return void */
	function dump()
	{
		for ($x = 0; $x < self::SIZE; $x++) {
			if ($x % 3 === 0) {
				echo str_repeat('+' . str_repeat('-', 7), 3), "+\n";
			}

			for ($y = 0; $y < self::SIZE; $y++) {
				echo $y % 3 === 0 ? '| ' : '', $this->values[$x][$y] ?: '-', ' ';
			}

			echo "|\n";
		}

		echo str_repeat('+' . str_repeat('-', 7), 3), "+\n\n";
	}


	/** @return void */
	private function validate()
	{
		$this->values = array_values($this->values);

		if (count($this->values) !== self::SIZE) {
			throw new InvalidBoardSizeException;
		}

		for ($x = 0; $x < self::SIZE; $x++) {
			$this->values[$x] = array_values($this->values[$x]);
			if (count($this->values[$x]) !== self::SIZE) {
				throw new InvalidBoardSizeException;
			}

			for ($y = 0; $y < self::SIZE; $y++) {
				if ($this->values[$x][$y] !== NULL) {
					$this->values[$x][$y] = (int) $this->values[$x][$y];
					if ($this->values[$x][$y] < 1 || $this->values[$x][$y] > self::SIZE) {
						throw new InvalidBoardValuesException;
					}
				}
			}
		}

		if (!$this->hasUniqueRows() || !$this->hasUniqueColumns() || !$this->hasUniqueSquares()) {
			throw new InvalidBoardValuesException;
		}
	}


	/** @return void */
	private function hasUniqueRows()
	{
		for ($x = 0; $x < self::SIZE; $x++) {
			$values = array();
			for ($y = 0; $y < self::SIZE; $y++) {
				$value = $this->values[$x][$y];

				if ($value !== NULL) {
					if (isset($values[$value])) {
						return FALSE;
					}

					$values[$value] = TRUE;
				}
			}
		}

		return TRUE;
	}


	/** @return void */
	private function hasUniqueColumns()
	{
		for ($y = 0; $y < self::SIZE; $y++) {
			$values = array();
			for ($x = 0; $x < self::SIZE; $x++) {
				$value = $this->values[$x][$y];

				if ($value !== NULL) {
					if (isset($values[$value])) {
						return FALSE;
					}

					$values[$value] = TRUE;
				}
			}
		}

		return TRUE;
	}


	/** @return void */
	private function hasUniqueSquares()
	{
		for ($i = 1; $i <= self::SIZE; $i++) {
			$values = array();
			for ($j = 0; $j < self::SIZE; $j++) {
				list ($x, $y) = self::coordsFromSquareNo($i);
				$x += floor($j / 3);
				$y += $j % 3;

				$value = $this->values[$x][$y];

				if ($value !== NULL) {
					if (isset($values[$value])) {
						return FALSE;
					}

					$values[$value] = TRUE;
				}
			}
		}

		return TRUE;
	}


	/** @return array|NULL */
	private function findEmptyField()
	{
		for ($x = 0; $x < self::SIZE; $x++) {
			for ($y = 0; $y < self::SIZE; $y++) {
				if ($this->values[$x][$y] === NULL) {
					return array($x, $y);
				}
			}
		}

		return NULL;
	}


	/**
	 * @param  int $x
	 * @param  int $y
	 * @param  int $value
	 * @return bool
	 */
	private function canBePlaced($x, $y, $value)
	{
		return !$this->isInRow($x, $value)
				&& !$this->isInColumn($y, $value)
				&& !$this->isInSquare(self::squareNoFromCoords($x, $y), $value);
	}


	/**
	 * @param  int $x
	 * @param  int $value
	 * @return bool
	 */
	private function isInRow($x, $value)
	{
		for ($y = 0; $y < self::SIZE; $y++) {
			if ($this->values[$x][$y] === $value) {
				return TRUE;
			}
		}

		return FALSE;
	}


	/**
	 * @param  int $y
	 * @param  int $value
	 * @return bool
	 */
	private function isInColumn($y, $value)
	{
		for ($x = 0; $x < self::SIZE; $x++) {
			if ($this->values[$x][$y] === $value) {
				return TRUE;
			}
		}

		return FALSE;
	}


	/**
	 * @param  int $n
	 * @param  int $value
	 * @return bool
	 */
	private function isInSquare($n, $value)
	{
		for ($i = 0; $i < self::SIZE; $i++) {
			list ($x, $y) = self::coordsFromSquareNo($n);

			$x += floor($i / 3);
			$y += $i % 3;

			if ($this->values[$x][$y] === $value) {
				return TRUE;
			}
		}

		return FALSE;
	}


	/**
	 * @param  int $x
	 * @param  int $y
	 * @return int
	 */
	private static function squareNoFromCoords($x, $y)
	{
		return 1 + (int) (3 * floor($x / 3) + floor($y / 3));
	}


	/**
	 * @param  int $n
	 * @return int[]
	 */
	private static function coordsFromSquareNo($n)
	{
		return array(
			(int) (floor(($n - 1) / 3) * 3),
			(int) ((($n - 1) % 3) * 3),
		);
	}

}


class InvalidBoardSizeException extends \Exception
{}


class InvalidBoardValuesException extends \Exception
{}
