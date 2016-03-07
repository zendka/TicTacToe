<?php

require_once dirname(__DIR__) . '/src/autoload.php';

use Florin\TicTacToe\Game as Game;

$types = [
  Game::HUMAN_VS_COMPUTER => "Play against computer - you first",
  Game::COMPUTER_VS_HUMAN => "Play against computer - computer first",
  Game::HUMAN_VS_HUMAN => "Play by yourself",
  Game::COMPUTER_VS_COMPUTER => "Watch the computer play by itself",
];

include('page.tpl.php');
