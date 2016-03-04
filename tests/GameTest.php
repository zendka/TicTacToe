<?php namespace Florin\TicTacToe;

class GameTest extends \PHPUnit_Framework_TestCase
{
    public function testGetConfig()
    {
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $game = new Game(new Grid($config));

        $this->assertEquals($config, $game->getConfig());
    }

    public function testWin()
    {
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $game = new Game(new Grid($config));
        $game->playTurn();

        $expectedConfig = [
          'O' , null , 'X',
          'X' , 'O' , 'X',
          null, null, 'O'
        ];
        $this->assertEquals($expectedConfig, $game->getConfig());
    }
}
