<?php

declare(strict_types=1);

namespace App\World;

use App\Exception\GameException;
use App\World\Element\Point;
use App\LinkedList\Singly;
use App\Terminal\Char;

class Snake
{
    /**
     * @var Singly
     */
    private $points;

    /**
     * @var string
     */
    private $direction = Direction::RIGHT;

    /**
     * @var int
     */
    private $landRows;

    /**
     * @var int
     */
    private $landCols;

    /**
     * @var Point[]|null
     */
    private $lastPoint;

    /** @var int */
    private $score = 0;

    /**
     * @param int $landRows
     * @param int $landCols
     */
    public function __construct(int $landRows, int $landCols)
    {
        $this->points = new Singly();

        $dividen = 2;
        $head = new Point(intval($landRows / $dividen), intval($landCols / $dividen), Char::block());

        $this->landCols = $landCols;
        $this->landRows = $landRows;

        for ($i = 1; $i < 5; ++$i) {
            $this->points->append(new Point($head->getRow(), $head->getCol() - $i, Char::shadeBlock()));
        }
        $this->points->prepend($head);
    }

    public function move(string $input)
    {
        $this->changeDirection($input);

        $point = $this->points->get(0);

        $row = $point->getRow();
        $col = $point->getCol();

        switch ($this->direction) {
            case Direction::RIGHT:
                $col++;
                break;
            case Direction::LEFT:
                $col--;
                break;
            case Direction::UP:
                $row--;
                break;
            case Direction::DOWN:
                $row++;
                break;
        }

        $landLessOne = 1;
        $landLessTwo = 1;

        if ($col >= $this->landCols - $landLessOne) {
            $col = $landLessOne;
        } elseif ($col < $landLessOne) {
            $col = $this->landCols - $landLessTwo;
        }

        if ($row >= $this->landRows - $landLessOne) {
            $row = $landLessOne;
        } elseif ($row < $landLessOne) {
            $row = $this->landRows - $landLessTwo;
        }

        $point->setChar(Char::shadeBlock());
        $this->points->updateSpecificNode(0, $point);

        $next = new Point($row, $col, Char::block());

        $this->checkCollision($next);

        $this->points->prepend($next);
        $this->lastPoint = $this->points->last();
        $this->points->deleteLast();
    }

    /**
     * @param Point $next
     *
     * @throws GameException
     */
    private function checkCollision(Point $next)
    {
        foreach ($this->points as $point) {
            if ($point->overlaps($next)) {
                throw GameException::snakeCollision();
            }
        }
    }

    public function advance()
    {
        $this->points->append($this->lastPoint);
    }

    /**
     * @param string $input
     */
    private function changeDirection(string $input)
    {
        if ('w' === $input && $this->direction != Direction::DOWN) {
            $this->direction = Direction::UP;
        } elseif ('a' === $input && $this->direction != Direction::RIGHT) {
            $this->direction = Direction::LEFT;
        } elseif ('s' === $input && $this->direction != Direction::UP) {
            $this->direction = Direction::DOWN;
        } elseif ('d' === $input && $this->direction != Direction::LEFT) {
            $this->direction = Direction::RIGHT;
        }
    }

    /**
     * @return array|Point[]
     */
    public function getPoints()
    {
        return $this->points->getList();
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * @param string $direction
     */
    public function setDirection(string $direction)
    {
        $this->direction = $direction;
    }

    public function addScore()
    {
        $this->score += 1;
    }

    public function getScore()
    {
        return $this->score;
    }
}
