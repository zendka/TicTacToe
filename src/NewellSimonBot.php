<?php namespace Florin\TicTacToe;

/**
 * Class NewellSimonBot
 *
 * Uses Newell and Simon's algorithm to play a TicTacToe game:
 * https://en.wikipedia.org/wiki/Tic-tac-toe
 */
class NewellSimonBot
{
    private $game;

    public function __construct(Game $game)
    {
        $this->game = $game;
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
        } elseif ($availableCentralPosition = $this->game->grid->getEmptyCentralPosition()) {
            $bestMoves = $availableCentralPosition;
        } elseif ($availableCornerPositions = $this->game->grid->getEmptyCornerPositions()) {
            $bestMoves = $availableCornerPositions;
        } else {
            $bestMoves = $this->game->grid->getEmptyPositions();
        }

        return self::random($bestMoves);
    }

    private function getWinningPositions($player)
    {
        return array_filter($this->game->grid->getEmptyPositions(),
          function ($position) use ($player) {
              $this->game->grid->markPosition(Game::$PLAYERS_MARKS[$player], $position);
              $isWinningPosition = $this->game->isWinner($player);
              $this->game->grid->removeMark($position);
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
        return array_filter($this->game->grid->getEmptyPositions(),
          function ($position) use ($player) {
              $this->game->grid->markPosition(Game::$PLAYERS_MARKS[$player], $position);
              $isForkPosition = count($this->getWinningPositions($player)) >= 2;
              $this->game->grid->removeMark($position);

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
        return array_filter($this->game->grid->getEmptyPositions(),
          function ($position) use ($player, $opponentsForkPositions) {
              $this->game->grid->markPosition(Game::$PLAYERS_MARKS[$player], $position);
              $winningPositions = $this->getWinningPositions($player);
              $isForceOpponentPosition = !empty($winningPositions) &&
                                         !array_intersect($winningPositions, $opponentsForkPositions);
              $this->game->grid->removeMark($position);

              return $isForceOpponentPosition;
          }
        );
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
