<?php namespace Florin\TicTacToe;

class GameTest extends \PHPUnit_Framework_TestCase
{
    public function testArgumentException()
    {
        $this->setExpectedException('InvalidArgumentException');
        $grid = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $game = new Game(new Grid($grid), 22);
    }

    public function testGetGrid()
    {
        $grid = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $game = new Game(new Grid($grid));

        $this->assertEquals($grid, $game->getGrid());
    }

    public function testGetType()
    {
        $grid = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $game = new Game(new Grid($grid), Game::HUMAN_VS_HUMAN);

        $this->assertEquals(Game::HUMAN_VS_HUMAN, $game->getType());
    }

    public function testOnlyPlaysItsTurn()
    {
        $grid = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $game = new Game(new Grid($grid), Game::HUMAN_VS_HUMAN);
        $game->playTurn();

        $this->assertEquals($grid, $game->getGrid());
    }

    public function testWin()
    {
        $grid = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $game = new Game(new Grid($grid));
        $game->playTurn();

        $expectedGrid = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, 'O'
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    public function testBlocksOpponent()
    {
        $grid = [
          'X' , null, 'X',
          'O' , null, null,
          null, 'X' , 'O'
        ];
        $game = new Game(new Grid($grid));
        $game->playTurn();

        $expectedGrid = [
          'X' , 'O' , 'X',
          'O' , null, null,
          null, 'X' , 'O'
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    public function testFork()
    {
        $grid = [
          'O' , 'X' , 'X',
          'X' , null, null,
          null, 'O' , null
        ];
        $game = new Game(new Grid($grid));
        $game->playTurn();

        $expectedGrid = [
          'O' , 'X' , 'X',
          'X' , null, null,
          null, 'O' , 'O'
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    public function testComputerBlocksOpponentsFork()
    {
        $grid = [
          'X' , null, 'O',
          'O' , null, 'X',
          'X' , null, null
        ];
        $game = new Game(new Grid($grid));
        $game->playTurn();

        $expectedGrid = [
          'X' , null, 'O',
          'O' , null, 'X',
          'X' , null, 'O'
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    public function testComputerBlocksOpponentsMultipleForks()
    {
        $grid = [
          'X' , null, null,
          null, 'O' , null,
          null, null, 'X'
        ];
        $game = new Game(new Grid($grid));
        $game->playTurn();

        $expectedGrids = [
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
        $this->assertTrue(in_array($game->getGrid(), $expectedGrids));
    }

    public function testComputerPlaysTheCenter()
    {
        $grid = [
          'X' , null, null,
          null, null, null,
          null, null, null
        ];
        $game = new Game(new Grid($grid));
        $game->playTurn();

        $expectedGrid = [
          'X' , null, null,
          null, 'O' , null,
          null, null, null
        ];
        $this->assertEquals($expectedGrid, $game->getGrid());
    }

    public function testComputerPlaysACorner()
    {
        $grid = [
          null, null, null,
          'X' , 'O' , 'X',
          null, null, null
        ];
        $game = new Game(new Grid($grid));
        $game->playTurn();

        $expectedGrids = [
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
        $this->assertTrue(in_array($game->getGrid(), $expectedGrids));
    }

    public function testComputerPlaysASide()
    {
        $grid = [
          'X' , 'O' , 'X',
          null, 'X' , null,
          'O' , 'X' , 'O'
        ];
        $game = new Game(new Grid($grid));
        $game->playTurn();

        $expectedGrids = [
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
        $this->assertTrue(in_array($game->getGrid(), $expectedGrids));
    }

    public function testIsOver()
    {
        $grid = [
          'O' , null, 'O',
          'X' , 'X' , 'X',
          null, null, null
        ];
        $game = new Game(new Grid($grid), Game::HUMAN_VS_HUMAN);

        $this->assertTrue($game->isOver());
    }

    public function testIsNotOver()
    {
        $grid = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $game = new Game(new Grid($grid), Game::HUMAN_VS_HUMAN);

        $this->assertFalse($game->isOver());
    }


    public function testGetWinner()
    {
        $grid = [
          'O' , null, 'O',
          'X' , 'X' , 'X',
          null, null, null
        ];
        $game = new Game(new Grid($grid), Game::HUMAN_VS_HUMAN);

        $this->assertEquals(1, $game->getWinner());
    }
}
