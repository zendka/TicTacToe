<?php

include('helper.php');

use Florin\TicTacToe\Game as Game;
use Florin\TicTacToe\Grid as Grid;


list($state, $type) = processInput();

$game = new Game(new Grid($state), $type);
$game->playTurn();

outputPageTemplate($game);
