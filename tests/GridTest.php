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

        $availablePositions = $grid->getAvailablePositions();
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

    public function testMarkPosition()
    {
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $grid = new Grid($config);
        $grid->markPosition(2, 8);

        $expectedConfig = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, 'O'
        ];
        $this->assertEquals($expectedConfig, $grid->getGrid());
    }

    public function testCountPositions()
    {
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $grid = new Grid($config);

        $this->assertEquals(3, $grid->countPositions(1));
    }
}
