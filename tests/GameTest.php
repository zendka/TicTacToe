<?php namespace Florin\TicTacToe;

class GameTest extends \PHPUnit_Framework_TestCase
{
    public function testGetState()
    {
        $state = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $game = new Game(new Grid($state));

        $this->assertEquals($state, $game->getState());
    }

    public function testWin()
    {
        $state = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $game = new Game(new Grid($state));
        $game->playTurn();

        $expectedState = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, 'O'
        ];
        $this->assertEquals($expectedState, $game->getState());
    }

    public function testBlocksOpponent()
    {
        $state = [
          'X' , null, 'X',
          'O' , null, null,
          null, 'X' , 'O'
        ];
        $game = new Game(new Grid($state));
        $game->playTurn();

        $expectedState = [
          'X' , 'O' , 'X',
          'O' , null, null,
          null, 'X' , 'O'
        ];
        $this->assertEquals($expectedState, $game->getState());
    }

    public function testFork()
    {
        $state = [
          'O' , 'X' , 'X',
          'X' , null, null,
          null, 'O' , null
        ];
        $game = new Game(new Grid($state));
        $game->playTurn();

        $expectedState = [
          'O' , 'X' , 'X',
          'X' , null, null,
          null, 'O' , 'O'
        ];
        $this->assertEquals($expectedState, $game->getState());
    }
}
