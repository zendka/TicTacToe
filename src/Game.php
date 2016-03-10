<?php namespace Florin\TicTacToe;

class Game
{
    const PLAYERS_MARKS = [
      1 => 'X',
      2 => 'O',
    ];

    const HUMAN_VS_COMPUTER    = 1;
    const COMPUTER_VS_HUMAN    = 2;
    const HUMAN_VS_HUMAN       = 3;
    const COMPUTER_VS_COMPUTER = 4;
    const TYPES = [
      self::HUMAN_VS_COMPUTER,
      self::COMPUTER_VS_HUMAN,
      self::HUMAN_VS_HUMAN,
      self::COMPUTER_VS_COMPUTER
    ];

    private $type = self::HUMAN_VS_COMPUTER;
    private $grid;
    private $bot;

    public function __construct(Grid $grid, $type = self::HUMAN_VS_COMPUTER, $bot = 'Florin\TicTacToe\NewellSimonBot')
    {
        if (!$this->isTypeValid($type)) {
            throw new \InvalidArgumentException('Wrong argument. $type not known.');
        }
        $this->grid = $grid;
        $this->type = $type;
        // @todo Validate $bot. Test class exists and implements interface with method getBestMove()?
        $this->bot = $bot;
    }

    private function isTypeValid($type)
    {
        return in_array($type, self::TYPES);
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
        return $this->grid->countPositions(self::PLAYERS_MARKS[1]) ==
            $this->grid->countPositions(self::PLAYERS_MARKS[2]) ?
            1 : 2;
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

        $bot = new $this->bot($this->grid, self::PLAYERS_MARKS);
        $bestPosition = $bot->getBestMove($currentPlayer);

        $this->grid->markPosition(self::PLAYERS_MARKS[$currentPlayer], $bestPosition);
    }

    private function isWinner($player)
    {
        return $this->grid->hasThreeInLine(self::PLAYERS_MARKS[$player]);
    }

    public function isOver()
    {
        return $this->getWinner() || empty($this->grid->getEmptyPositions());
    }

    public function getWinner()
    {
        return $this->isWinner(1) ? 1 : ($this->isWinner(2) ? 2 : false);
    }
}
