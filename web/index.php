<?php

include('helper.php');

use Florin\TicTacToe\Game as Game;
use Florin\TicTacToe\Grid as Grid;

list($gameType, $grid) = getInput();

$game = new Game(new Grid($grid), $gameType);
$game->playTurn();

displayPage($game);
