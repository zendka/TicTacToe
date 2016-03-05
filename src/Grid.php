<?php namespace Florin\TicTacToe;

/**
 * Class Grid
 *
 * Represents a 3x3 grid containing 'X', 'O' and null.
 * Grid's positions are numbered as follows:
 *
 * 0, 1, 2,
 * 3, 4, 5,
 * 6, 7, 8,
 */
class Grid
{
    const POSITIONS = [0, 1, 2, 3, 4, 5, 6, 7, 8];

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

    private $playersPositions = [];

    // @todo Validate input
    public function __construct(array $state)
    {
        $this->playersPositions[1] = array_keys($state, 'X');
        $this->playersPositions[2] = array_keys($state, 'O');
    }

    public function getState()
    {
        // @todo const EMPTY_GRID
        $state = [null, null, null, null, null, null, null, null, null];

        foreach ($this->playersPositions[1] as $position) {
            $state[$position] = 'X';
        }
        foreach ($this->playersPositions[2] as $position) {
            $state[$position] = 'O';
        }
        return $state;
    }

    public function getAvailablePositions()
    {
        $occupiedPositions = array_merge($this->playersPositions[1], $this->playersPositions[2]);
        return array_diff(Grid::POSITIONS, $occupiedPositions);
    }

    public function markPosition($player, $position)
    {
        array_push($this->playersPositions[$player], $position);
    }

    public function cancelLastMark($player)
    {
        array_pop($this->playersPositions[$player]);
    }

    public function countPositions($player)
    {
        return count($this->playersPositions[$player]);
    }

    public function hasThreeInLine($player) {
        $lines = array_merge(array_merge(self::ROWS, self::COLUMNS), self::DIAGONALS);
        
        foreach ($lines as $line) {
            $positionsOnThisLine = array_intersect($this->playersPositions[$player], $line);
            if (count($positionsOnThisLine) == 3) {
                return true;
            }
        }
        return false;
    }
}
