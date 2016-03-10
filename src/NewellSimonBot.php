<?php namespace Florin\TicTacToe;

/**
 * Class NewellSimonBot
 *
 * Uses Newell and Simon's algorithm to play a TicTacToe game:
 * https://en.wikipedia.org/wiki/Tic-tac-toe
 */
class NewellSimonBot
{
    private $grid;
    private $playersMarks;

    public function __construct(Grid $grid, array $playersMarks)
    {
        $this->grid = $grid;
        $this->playersMarks = $playersMarks;
    }

    public function getBestMove($player)
    {
        $opponent = self::getOpponent($player);

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
        } elseif ($availableCentralPosition = $this->grid->getEmptyCentralPosition()) {
            $bestMoves = $availableCentralPosition;
        } elseif ($availableCornerPositions = $this->grid->getEmptyCornerPositions()) {
            $bestMoves = $availableCornerPositions;
        } else {
            $bestMoves = $this->grid->getEmptyPositions();
        }

        return self::random($bestMoves);
    }

    private function getWinningPositions($player)
    {
        return array_filter($this->grid->getEmptyPositions(),
          function ($position) use ($player) {
              $this->grid->markPosition(Game::$PLAYERS_MARKS[$player], $position);
              $isWinningPosition = $this->isWinner($player);
              $this->grid->removeMark($position);
              return $isWinningPosition;
          }
        );
    }

    /**
     * Gets fork positions for player
     *
     * A fork position is an unmarked position that if marked creates two future winning positions.
     * The opponent can only block one. So this is a future win.
     */
    private function getForkPositions($player)
    {
        return array_filter($this->grid->getEmptyPositions(),
          function ($position) use ($player) {
              $this->grid->markPosition(Game::$PLAYERS_MARKS[$player], $position);
              $isForkPosition = count($this->getWinningPositions($player)) >= 2;
              $this->grid->removeMark($position);

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
        return array_filter($this->grid->getEmptyPositions(),
          function ($position) use ($player, $opponentsForkPositions) {
              $this->grid->markPosition(Game::$PLAYERS_MARKS[$player], $position);
              $winningPositions = $this->getWinningPositions($player);
              $isForceOpponentPosition = !empty($winningPositions) &&
                                         !array_intersect($winningPositions, $opponentsForkPositions);
              $this->grid->removeMark($position);

              return $isForceOpponentPosition;
          }
        );
    }

    private function isWinner($player)
    {
        return $this->grid->hasThreeInLine($this->playersMarks[$player]);
    }

    private static function random(array $positions)
    {
        return $positions[array_rand($positions)];
    }

    private static function getOpponent($player)
    {
        return $player == 1 ? 2 : 1;
    }
}
