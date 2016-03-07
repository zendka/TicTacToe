<?php

require_once dirname(__DIR__) . '/src/autoload.php';

use Florin\TicTacToe\Game as Game;
use Florin\TicTacToe\Grid as Grid;


function processInput()
{
    $state = isset($_GET['state']) ? $_GET['state'] : Grid::INITIAL_STATE;
    $type  = isset($_GET['type']) ? $_GET['type'] : Game::HUMAN_VS_COMPUTER;
    return [$state, $type];
}

function outputPageTemplate(Game $game)
{
    // Initialise variables to be used in the template
    $computerVsComputer = $game->getType() == Game::COMPUTER_VS_COMPUTER;
    $gameOver = $game->isOver();
    $currentPlayer = $game->isFirstPlayersTurn() == 1 ? 'X' : 'O';

    include('page.tpl.php');
}

function outputGridTemplate(Game $game)
{
    // Initialise variables to be used in the template
    $type = $game->getType();
    $state = $game->getState();
    $available = [];
    foreach ($state as $position => $mark) {
        $available[$position] = !$mark && !$game->isOver() && $game->getType() != Game::COMPUTER_VS_COMPUTER;
    }

    include('grid.tpl.php');
}

function outputGameTypeTemplate()
{
    // Initialise variables to be used in the template
    $types = [
      Game::HUMAN_VS_COMPUTER => "Play against computer - you first",
      Game::COMPUTER_VS_HUMAN => "Play against computer - computer first",
      Game::HUMAN_VS_HUMAN => "Play by yourself",
      Game::COMPUTER_VS_COMPUTER => "Watch the computer play by itself",
    ];

    include('type.tpl.php');
}
