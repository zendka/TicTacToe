<?php namespace Florin\TicTacToe;

/**
 * Class Grid
 *
 * Represents a 3x3 grid.
 *
 * Grid's positions are numbered as follows:
 *
 * 0, 1, 2,
 * 3, 4, 5,
 * 6, 7, 8,
 */
class Grid
{
    const EMPTY_GRID = [
        null, null, null,
        null, null, null,
        null, null, null,
    ];

    const POSITIONS = [
      0, 1, 2,
      3, 4, 5,
      6, 7, 8
    ];

    const CORNERS   = [0, 2, 6, 8];
    const SIDES     = [1, 3, 5, 7];
    const CENTER    = [4];

    const DIAGONALS = [
      [0, 4, 8],
      [2, 4, 6],
    ];
    const ROWS = [
      [0, 1, 2],
      [3, 4, 5],
      [6, 7, 8],
    ];
    const COLUMNS = [
      [0, 3, 6],
      [1, 4, 7],
      [2, 5, 8],
    ];

    private $grid = self::EMPTY_GRID;

    public function __construct(array $grid = self::EMPTY_GRID)
    {
        if (!$this->isValidGrid($grid)) {
            throw new \InvalidArgumentException('Wrong argument. Sequential array of null, strings and integers expected.');
        }
        $this->grid = $grid;
    }

    private function isValidGrid(array $grid)
    {
        foreach ($grid as $value) {
            if (!empty($value) && !is_string($value) && !is_int($value)) {
                return false;
            }
        }
        return array_keys($grid) === range(0, 8);
    }

    public function getGrid()
    {
        return $this->grid;
    }

    public function markPosition($mark, $position)
    {
        $this->grid[$position] = $mark;
    }

    public function removeMark($position)
    {
        $this->grid[$position] = null;
    }

    public function getEmptyPositions()
    {
        return array_keys($this->grid, null);
    }

    public function getEmptyCentralPosition()
    {
        return array_intersect($this->getEmptyPositions(), Grid::CENTER);
    }

    public function getEmptyCornerPositions()
    {
        return array_intersect($this->getEmptyPositions(), Grid::CORNERS);
    }

    public function countPositions($mark)
    {
        return count(array_keys($this->grid, $mark));
    }

    public function hasThreeInLine($mark) {
        $lines = array_merge(self::ROWS, self::COLUMNS, self::DIAGONALS);
        $markPositions = array_keys($this->grid, $mark);

        foreach ($lines as $line) {
            $positionsOnThisLine = array_intersect($markPositions, $line);
            if (count($positionsOnThisLine) == 3) {
                return true;
            }
        }
        return false;
    }
}
