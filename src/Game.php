<?php namespace Florin\TicTacToe;

class Game
{
    const HUMAN_VS_COMPUTER    = 1;
    const COMPUTER_VS_HUMAN    = 2;
    const HUMAN_VS_HUMAN       = 3;
    const COMPUTER_VS_COMPUTER = 4;

    private $type = self::HUMAN_VS_COMPUTER;
    private $grid;

    // @todo Validate input
    public function __construct(Grid $grid, $type = self::HUMAN_VS_COMPUTER)
    {
        $this->grid = $grid;
        $this->type = $type;
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
        if (!$this->isComputersTurn()) {
            return;
        }

        $currentPlayer = $this->getCurrentPlayer();
        $bestPosition = $this->getBestMove($currentPlayer);

        $this->grid->markPosition($currentPlayer, $bestPosition);
    }

    private function isComputersTurn()
    {
        return $this->type == self::COMPUTER_VS_COMPUTER ||
               $this->type == self::COMPUTER_VS_HUMAN && $this->isFirstPlayersTurn() ||
               $this->type == self::HUMAN_VS_COMPUTER && $this->isSecondPlayersTurn();
    }

    private function isFirstPlayersTurn()
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

    private static function random(array $positions)
    {
        return $positions[array_rand($positions)];
    }

    // Use Newell and Simon's algorithm: https://en.wikipedia.org/wiki/Tic-tac-toe
    private function getBestMove($player)
    {
        $opponent = $player == 1 ? 2 : 1;

        if ($winningPositions = $this->getWinningPositions($player)) {
            $bestMoves = $winningPositions;
        } elseif ($opponentsWinningPositions = $this->getWinningPositions($opponent)) {
            // Block opponent by marking its winning position
            $bestMoves = $opponentsWinningPositions;
        } elseif ($forkPositions = $this->getForkPositions($player)) {
            $bestMoves = $forkPositions;
        } elseif ($opponentsForkPositions = $this->getForkPositions($opponent)) {
            $canBlockOpponent = sizeof($opponentsForkPositions) == 1;
            if ($canBlockOpponent) {
                $bestMoves = $opponentsForkPositions;
            } else {
                $forceOpponentPositions = $this->getForceOpponentPositions($player, $opponentsForkPositions);
                $bestMoves = $forceOpponentPositions;
            }
        } elseif ($availableCentralPosition = array_intersect($this->grid->getAvailablePositions(), Grid::CENTER)) {
            $bestMoves = $availableCentralPosition;
        } elseif ($availableCornerPositions = array_intersect($this->grid->getAvailablePositions(), Grid::CORNERS)) {
            $bestMoves = $availableCornerPositions;
        } else {
            $bestMoves = $this->grid->getAvailablePositions();
        }

        return self::random($bestMoves);
    }

    private function getWinningPositions($player)
    {
        return array_filter($this->grid->getAvailablePositions(),
          function ($position) use ($player) {
              $this->grid->markPosition($player, $position);
              $isWinningPosition = $this->isWinner($player);
              $this->grid->cancelLastMark($player);
              return $isWinningPosition;
          }
        );
    }

    private function isWinner($player)
    {
        return $this->grid->hasThreeInLine($player);
    }

    /**
     * Gets fork positions for player
     *
     * A fork position is an unmarked position that if marked creates two future winning positions.
     * The opponent can only block one. So this is a future win.
     */
    private function getForkPositions($player)
    {
        return array_filter($this->grid->getAvailablePositions(),
          function ($position) use ($player) {
              $this->grid->markPosition($player, $position);
              $isForkPosition = count($this->getWinningPositions($player)) >= 2;
              $this->grid->cancelLastMark($player);

              return $isForkPosition;
          }
        );
    }

    /**
     * Get the "force opponent" positions
     *
     * A "force opponent" position is one that creates a future winning position
     * The opponent will be forced to block this position in order not to lose.
     * Make sure that the position to be blocked by the opponent is not a winning one for him.
     */
    private function getForceOpponentPositions($player, $opponentsForkPositions)
    {
        return array_filter($this->grid->getAvailablePositions(),
          function ($position) use ($player, $opponentsForkPositions) {
              $this->grid->markPosition($player, $position);
              $winningPositions = $this->getWinningPositions($player);
              $isForceOpponentPosition = !empty($winningPositions) &&
                                         !array_intersect($winningPositions, $opponentsForkPositions);
              $this->grid->cancelLastMark($player);

              return $isForceOpponentPosition;
          }
        );
    }
}
