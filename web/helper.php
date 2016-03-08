<?php

require_once dirname(__DIR__) . '/src/autoload.php';

use Florin\TicTacToe\Game as Game;
use Florin\TicTacToe\Grid as Grid;

function getInput()
{
    $gameType  = isset($_GET['gameType']) ? $_GET['gameType'] : Game::HUMAN_VS_COMPUTER;
    $gridState = isset($_GET['gridState']) ? $_GET['gridState'] : Grid::INITIAL_STATE;
    return [$gameType, $gridState];
}

function displayPage(Game $game)
{
    // Initialise variables to be used in the template
    $isComputerVsComputer = $game->getType() == Game::COMPUTER_VS_COMPUTER;
    $isGameOver = $game->isOver();
    $currentPlayer = $game->isFirstPlayersTurn() == 1 ? 'X' : 'O';
    $winner = $game->getWinner();
    if ($isGameOver) {
        $message = !$winner ?
          'It is a draw' :
          ($game->getType() == Game::HUMAN_VS_HUMAN ? "Player $winner won" : 'Computer won');
    }

    include('page.tpl.php');
}

function displayGrid(Game $game)
{
    // Initialise variables to be used in the template
    $gameType = $game->getType();
    $gridState = $game->getState();
    $available = [];
    foreach ($gridState as $position => $mark) {
        $available[$position] = !$mark && !$game->isOver() && $game->getType() != Game::COMPUTER_VS_COMPUTER;
    }

    include('grid.tpl.php');
}

function displayGameType()
{
    // Initialise variables to be used in the template
    $gameTypes = [
      Game::HUMAN_VS_COMPUTER => "Play against computer - you first",
      Game::COMPUTER_VS_HUMAN => "Play against computer - computer first",
      Game::HUMAN_VS_HUMAN => "Play by yourself",
      Game::COMPUTER_VS_COMPUTER => "Watch the computer play by itself",
    ];

    include('game-type.tpl.php');
}
