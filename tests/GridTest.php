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
        sort($availablePositions);
        $this->assertEquals([1, 6, 7, 8], $availablePositions);
    }

    public function testGetConfig()
    {
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $grid = new Grid($config);

        $this->assertEquals($config, $grid->getConfig());
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
        $this->assertEquals($expectedConfig, $grid->getConfig());
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

    public function testHasThreeInLine()
    {
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, 'O'
        ];
        $grid = new Grid($config);

        $this->AssertTrue($grid->hasThreeInLine(2));
    }

    public function testHasThreeInLineNot()
    {
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, 'O'
        ];
        $grid = new Grid($config);

        $this->AssertFalse($grid->hasThreeInLine(1));
    }
}
