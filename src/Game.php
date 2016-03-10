<?php namespace Florin\TicTacToe;

class Game
{
    static public $PLAYERS_MARKS = [1 => 'X', 2 => 'O'];

    const HUMAN_VS_COMPUTER    = 1;
    const COMPUTER_VS_HUMAN    = 2;
    const HUMAN_VS_HUMAN       = 3;
    const COMPUTER_VS_COMPUTER = 4;

    private $type = self::HUMAN_VS_COMPUTER;
    // @todo make private and make it array instead of Grid!! I don't need to know about the representation!!!
    public $grid;
    private $bot;

    // @todo Validate input
    public function __construct(Grid $grid, $type = self::HUMAN_VS_COMPUTER, $bot = 'Florin\TicTacToe\NewellSimonBot')
    {
        $this->grid = $grid;
        $this->type = $type;
        $this->bot = $bot;
    }

    public function getGrid()
    {
        return $this->grid->getGrid();
    }

    public function getType()
    {
        return $this->type;
    }

    public function getCurrentPlayer()
    {
        return $this->grid->countPositions(self::$PLAYERS_MARKS[1]) ==
            $this->grid->countPositions(self::$PLAYERS_MARKS[2]) ?
            1 : 2;
    }

    public function getWinner()
    {
        return $this->isWinner(1) ? 1 : ($this->isWinner(2) ? 2 : false);
    }

    public function isWinner($player)
    {
        return $this->grid->hasThreeInLine(self::$PLAYERS_MARKS[$player]);
    }

    public function isOver()
    {
        return $this->getWinner() || empty($this->grid->getEmptyPositions());
    }

    private function isComputersTurn()
    {
        return $this->type == self::COMPUTER_VS_COMPUTER ||
               $this->type == self::COMPUTER_VS_HUMAN && $this->getCurrentPlayer() == 1 ||
               $this->type == self::HUMAN_VS_COMPUTER && $this->getCurrentPlayer() == 2;
    }

    public function playTurn()
    {
        if ($this->isOver() || !$this->isComputersTurn()) {
            return;
        }

        $currentPlayer = $this->getCurrentPlayer();

        $bot = new $this->bot($this->grid, self::$PLAYERS_MARKS);
        $bestPosition = $bot->getBestMove($currentPlayer);

        $this->grid->markPosition(self::$PLAYERS_MARKS[$currentPlayer], $bestPosition);
    }
}
