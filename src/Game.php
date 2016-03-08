<?php namespace Florin\TicTacToe;

class Game
{
    const HUMAN_VS_COMPUTER    = 1;
    const COMPUTER_VS_HUMAN    = 2;
    const HUMAN_VS_HUMAN       = 3;
    const COMPUTER_VS_COMPUTER = 4;

    private $type = self::HUMAN_VS_COMPUTER;
    public $grid;
    private $bot;

    // @todo Validate input
    public function __construct(Grid $grid, $type = self::HUMAN_VS_COMPUTER, $bot = 'NewellSimonBot')
    {
        $this->grid = $grid;
        $this->type = $type;
        $this->bot = $bot;
    }

    public function getState()
    {
        return $this->grid->getState();
    }

    public function getType()
    {
        return $this->type;
    }

    public function playTurn()
    {
        if ($this->isOver() || !$this->isComputersTurn()) {
            return;
        }

        $currentPlayer = $this->getCurrentPlayer();

        $bot = new NewellSimonBot($this);
        $bestPosition = $bot->getBestMove($currentPlayer);

        $this->grid->markPosition($currentPlayer, $bestPosition);
    }

    private function isComputersTurn()
    {
        return $this->type == self::COMPUTER_VS_COMPUTER ||
               $this->type == self::COMPUTER_VS_HUMAN && $this->isFirstPlayersTurn() ||
               $this->type == self::HUMAN_VS_COMPUTER && $this->isSecondPlayersTurn();
    }

    public function isFirstPlayersTurn()
    {
        return $this->grid->countPositions(1) == $this->grid->countPositions(2);
    }

    private function isSecondPlayersTurn()
    {
        return !$this->isFirstPlayersTurn();
    }

    private function getCurrentPlayer()
    {
        return $this->isFirstPlayersTurn() ? 1 : 2;
    }

    public function isWinner($player)
    {
        return $this->grid->hasThreeInLine($player);
    }

    public function isOver()
    {
        return $this->getWinner() || empty($this->grid->getAvailablePositions()) ? true : false;
    }

    public function getWinner()
    {
        return $this->isWinner(1) ? 1 : ($this->isWinner(2) ? 2 : false);
    }
}
