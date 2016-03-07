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

    public function testGetType()
    {
        $state = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $game = new Game(new Grid($state), Game::HUMAN_VS_HUMAN);

        $this->assertEquals(Game::HUMAN_VS_HUMAN, $game->getType());
    }

    public function testOnlyPlaysItsTurn()
    {
        $state = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $game = new Game(new Grid($state), Game::HUMAN_VS_HUMAN);
        $game->playTurn();

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

    public function testComputerBlocksOpponentsFork()
    {
        $state = [
          'X' , null, 'O',
          'O' , null, 'X',
          'X' , null, null
        ];
        $game = new Game(new Grid($state));
        $game->playTurn();

        $expectedState = [
          'X' , null, 'O',
          'O' , null, 'X',
          'X' , null, 'O'
        ];
        $this->assertEquals($expectedState, $game->getState());
    }

    public function testComputerBlocksOpponentsMultipleForks()
    {
        $state = [
          'X' , null, null,
          null, 'O' , null,
          null, null, 'X'
        ];
        $game = new Game(new Grid($state));
        $game->playTurn();

        $expectedStates = [
          [
            'X' , 'O' , null,
            null, 'O' , null,
            null, null, 'X'
          ],
          [
            'X' , null, null,
            'O' , 'O' , null,
            null, null, 'X'
          ],
          [
            'X' , null, null,
            null, 'O' , 'O' ,
            null, null, 'X'
          ],
          [
            'X' , null, null,
            null, 'O' , null,
            null, 'O' , 'X'
          ]
        ];
        $this->assertTrue(in_array($game->getState(), $expectedStates));
    }

    public function testComputerPlaysTheCenter()
    {
        $state = [
          'X' , null, null,
          null, null, null,
          null, null, null
        ];
        $game = new Game(new Grid($state));
        $game->playTurn();

        $expectedState = [
          'X' , null, null,
          null, 'O' , null,
          null, null, null
        ];
        $this->assertEquals($expectedState, $game->getState());
    }

    public function testComputerPlaysACorner()
    {
        $state = [
          null, null, null,
          'X' , 'O' , 'X',
          null, null, null
        ];
        $game = new Game(new Grid($state));
        $game->playTurn();

        $expectedStates = [
          [
            'O' , null, null,
            'X' , 'O' , 'X',
            null, null, null
          ],
          [
            null, null, 'O',
            'X' , 'O' , 'X',
            null, null, null
          ],
          [
            null, null, null,
            'X' , 'O' , 'X',
            null, null, 'O'
          ],
          [
            null, null, null,
            'X' , 'O' , 'X',
            'O' , null, null
          ]
        ];
        $this->assertTrue(in_array($game->getState(), $expectedStates));
    }

    public function testComputerPlaysASide()
    {
        $state = [
          'X' , 'O' , 'X',
          null, 'X' , null,
          'O' , 'X' , 'O'
        ];
        $game = new Game(new Grid($state));
        $game->playTurn();

        $expectedStates = [
          [
            'X' , 'O' , 'X',
            null, 'X' , 'O',
            'O' , 'X' , 'O'
          ],
          [
            'X' , 'O' , 'X',
            'O' , 'X' , null,
            'O' , 'X' , 'O'
          ]
        ];
        $this->assertTrue(in_array($game->getState(), $expectedStates));
    }
}
