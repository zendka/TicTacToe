<?php namespace Florin\TicTacToe;

class GridTest extends \PHPUnit_Framework_TestCase
{

    public function testArgumentExceptionWithTooManyValues()
    {
        $this->setExpectedException('InvalidArgumentException');
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null,
          null,
        ];
        $grid = new Grid($config);

        $this->assertEquals($config, $grid->getGrid());
    }

    public function testArgumentExceptionWithUnsuitableType()
    {
        $this->setExpectedException('InvalidArgumentException');
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, [1],
        ];
        $grid = new Grid($config);

        $this->assertEquals($config, $grid->getGrid());
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
        $grid->markPosition('O', 8);

        $expectedConfig = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, 'O'
        ];
        $this->assertEquals($expectedConfig, $grid->getGrid());
    }

    public function testRemoveMark()
    {
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, 'O'
        ];
        $grid = new Grid($config);
        $grid->removeMark(5);

        $expectedConfig = [
          'O' , null, 'X',
          'X' , 'O' , null,
          null, null, 'O'
        ];
        $this->AssertEquals($expectedConfig, $grid->getGrid());
    }

    public function testGetEmptyPositions()
    {
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $grid = new Grid($config);

        $emptyPositions = $grid->getEmptyPositions();
        sort($emptyPositions);
        $this->assertEquals([1, 6, 7, 8], $emptyPositions);
    }

    public function testGetEmptyCentralPosition()
    {
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $grid = new Grid($config);

        $this->assertEquals([], $grid->getEmptyCentralPosition());
    }

    public function testGetEmptyCornerPositions()
    {
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $grid = new Grid($config);

        $emptyCornerPositions = $grid->getEmptyCornerPositions();
        sort($emptyCornerPositions);
        $this->assertEquals([6, 8], $emptyCornerPositions);
    }

    public function testCountPositions()
    {
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, null
        ];
        $grid = new Grid($config);

        $this->assertEquals(3, $grid->countPositions('X'));
    }

    public function testHasThreeInLine()
    {
        $config = [
          'O' , null, 'X',
          'X' , 'O' , 'X',
          null, null, 'O'
        ];
        $grid = new Grid($config);

        $this->AssertTrue($grid->hasThreeInLine('O'));
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
