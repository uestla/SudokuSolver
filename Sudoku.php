<?php


class Sudoku
{

	/** @var array */
	private $values;


	const SIZE = 9;


	/** @param  array $values */
	public function __construct(array $values)
	{
		$this->values = $values;
		$this->validate();
	}


	/** @return void */
	public function solve()
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
	public function getValues()
	{
		return $this->values;
	}


	/** @return void */
	public function dump()
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

					if ($this->values[$x][$y] === 0) {
						$this->values[$x][$y] = NULL;

					} elseif ($this->values[$x][$y] < 0 || $this->values[$x][$y] > self::SIZE) {
						throw new InvalidBoardValuesException;

					} else {
						$value = $this->values[$x][$y];
						$this->values[$x][$y] = NULL;

						if (!$this->canBePlaced($x, $y, $value)) {
							throw new InvalidBoardValuesException;
						}

						$this->values[$x][$y] = $value;
					}
				}
			}
		}
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
		for ($i = 0; $i < self::SIZE; $i++) {
			if ($this->values[$x][$i] === $value || $this->values[$i][$y] === $value) {
				return FALSE;
			}
		}

		$x1 = floor($x / 3) * 3;
		$y1 = floor($y / 3) * 3;

		for ($i = 0; $i < self::SIZE; $i++) {
			if ($this->values[$x1 + floor($i / 3)][$y1 + ($i % 3)] === $value) {
				return FALSE;
			}
		}

		return TRUE;
	}

}


class InvalidBoardSizeException extends \Exception
{}


class InvalidBoardValuesException extends \Exception
{}
