<?php namespace Florin\TicTacToe;

class GridTest extends \PHPUnit_Framework_TestCase
{
    public function testAvailablePositions()
    {
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $grid = new Grid($config);

        $availablePositions = $grid->availablePositions();
        $this->assertTrue(sort($availablePositions) == [1, 6, 7, 8]);
    }

    public function testGetGrid()
    {
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $grid = new Grid($config);

        $this->assertEquals($config, $grid->getGrid());
    }
}
