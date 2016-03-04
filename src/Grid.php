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

    const DIAGONAL1 = [0, 4, 8];
    const DIAGONAL2 = [2, 4, 6];
    const ROW1      = [0, 1, 2];
    const ROW2      = [3, 4, 5];
    const ROW3      = [6, 7, 8];
    const COLUMN1   = [0, 3, 6];
    const COLUMN2   = [1, 4, 7];
    const COLUMN3   = [2, 5, 8];

    const DIAGONALS = [
        self::DIAGONAL1,
        self::DIAGONAL2
    ];
    const ROWS = [
        self::ROW1,
        self::ROW2,
        self::ROW3
    ];
    const COLUMNS = [
        self::COLUMN1,
        self::COLUMN2,
        self::COLUMN3
    ];
    const LINES = [
        self::DIAGONAL1,
        self::DIAGONAL2,
        self::ROW1,
        self::ROW2,
        self::ROW3,
        self::COLUMN1,
        self::COLUMN2,
        self::COLUMN3,
    ];

    private $playersPositions = [];

    // @todo Validate input
    public function __construct(array $config)
    {
        $this->playersPositions[1] = array_keys($config, 'X');
        $this->playersPositions[2] = array_keys($config, 'O');
    }

    // @todo Find a better name
    public function getConfig()
    {
        // @todo const EMPTY_GRID
        $grid = [null, null, null, null, null, null, null, null, null];

        foreach ($this->playersPositions[1] as $position) {
            $grid[$position] = 'X';
        }
        foreach ($this->playersPositions[2] as $position) {
            $grid[$position] = 'O';
        }
        return $grid;
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

    public function countPositions($player)
    {
        return count($this->playersPositions[$player]);
    }

    public function hasThreeInLine($player) {
        foreach (Grid::LINES as $line) {
            $positionsOnThisLine = array_intersect($this->playersPositions[$player], $line);
            if (count($positionsOnThisLine) == 3) {
                return true;
            }
        }
        return false;
    }
}
