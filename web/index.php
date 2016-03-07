<?php

require_once dirname(__DIR__) . '/src/autoload.php';

use Florin\TicTacToe\Game as Game;
use Florin\TicTacToe\Grid as Grid;

$types = [
  Game::HUMAN_VS_COMPUTER => "Play against computer - you first",
  Game::COMPUTER_VS_HUMAN => "Play against computer - computer first",
  Game::HUMAN_VS_HUMAN => "Play by yourself",
  Game::COMPUTER_VS_COMPUTER => "Watch the computer play by itself",
];

$config = [
  'O' , null, 'X',
  'X' , 'O' , 'X',
  null, null, null
];
$game = new Game(new Grid($config));

$state = $game->getState();
$available = [];
foreach ($state as $position => $mark) {
    $available[$position] = !$mark && !$game->isOver() && $game->getType() != Game::COMPUTER_VS_COMPUTER;
}

include('page.tpl.php');
