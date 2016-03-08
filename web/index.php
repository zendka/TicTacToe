<?php

include('helper.php');

use Florin\TicTacToe\Game as Game;
use Florin\TicTacToe\Grid as Grid;

list($gameType, $gridState) = getInput();

$game = new Game(new Grid($gridState), $gameType);
$game->playTurn();

displayPage($game);
