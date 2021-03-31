<?php

declare(strict_types=1);

namespace App\World;

use App\Exception\GameException;
use App\World\Element\Coin;
use App\World\Element\Point;
use App\LinkedList\Singly;
use App\Terminal\Char;

class Land
{
    /**
     * @var int
     */
    private $width;

    /**
     * @var int
     */
    private $height;

    /**
     * @var Singly
     */
    private $map;

    /**
     * @var Singly
     */
    private $sourceMap;

    /**
     * @var Snake
     */
    private $snake;

    /**
     * @var Singly
     */
    private $coins;

    /**
     * @param int $width
     * @param int $height
     */
    public function __construct(int $width, int $height)
    {
        $this->width = $width;
        $this->height = $height;

        $this->coins = new Singly();
        $this->map = new Singly();

        $this->snake = new Snake($height, $width);
        $this->randomCoins(1);

        $this->generateMap();
        $this->generateOutline();
        $this->sourceMap = deepClone($this->map);

        $this->applyElements();
    }

    public function randomCoins(int $count)
    {
        for ($i = 0; $i < $count; ++$i) {
            $col = rand(2, $this->width - 3);
            $row = rand(2, $this->height - 3);

            $this->coins->append(new Coin($row, $col));
        }
    }

    public function moveSnake(string $input)
    {
        $this->snake->move($input);
        $this->checkCoins();
        $this->applyElements();
    }

    private function checkCoins()
    {
        $head = $this->snake->getPoints()[0];
        $coins = $this->coins->getList();

        if (!empty($coins)) {
            foreach ($coins as $index => $coin) {
                if ($head->overlaps($coin)) {
                    $this->snake->addScore();
                    $this->snake->advance();
                    $this->coins->delete($index);
                    $this->randomCoins(1);
                }
            }
        }
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @return array
     */
    public function getMap()
    {
        return $this->map->getList();
    }

    public function showScore()
    {
        return $this->snake->getScore();
    }

    public function updateMap($row, $col, $data)
    {
        $cols = $this->map->get($row);

        $cols[$col] = $data;

        $this->map->updateSpecificNode($row, $cols);
    }

    public function writeGameOver()
    {
        $text = 'GAME OVER';
        $length = strlen($text);
        $col = ($this->width / 2) - ($length / 2);
        $row = $this->height / 2;

        for ($i = 0; $i < $length; ++$i) {
            // var_dump($row, $col);
            $this->updateMap(intval($row), intval($col), $text[$i]);

            ++$col;
        }
    }

    private function applyElements()
    {
        $this->map = deepClone($this->sourceMap);

        $this->checkCollision();

        foreach ($this->snake->getPoints() as $point) {
            $this->applyPoint($point);
        }

        $coins = $this->coins->getList();
        if (!empty($coins)) {
            foreach ($coins as $coin) {
                $this->applyPoint($coin);
            }
        }
    }

    private function getBorder()
    {
        $width = $this->width;
        $height = $this->height;

        $widthLessOne = $width - 1;
        $widthLessTwo = $width - 2;

        $heightLessOne = $height - 1;
        $heightLessTwo = $height - 2;

        return [$widthLessOne, $widthLessTwo, $heightLessOne, $heightLessTwo];
    }

    /**
     * @param Point $next
     *
     * @throws GameException
     */
    private function checkCollision()
    {
        $idxOne = 1;

        list(
            $widthLessOne,
            $widthLessTwo,
            $heightLessOne,
            $heightLessTwo
        ) = $this->getBorder();

        $point = current($this->snake->getPoints());
        // HLine
        $this->checkHLineCollision($idxOne, $idxOne, $widthLessTwo, $point);
        $this->checkHLineCollision($heightLessOne, $idxOne, $widthLessTwo, $point);

        // VLine
        $this->checkVLineCollision($idxOne, $idxOne, $heightLessTwo, $point);
        $this->checkVLineCollision($widthLessOne, $idxOne, $heightLessTwo, $point);
    }

    /**
     * @param Point $point
     */
    private function applyPoint(Point $point)
    {
        $this->updateMap($point->getRow(), $point->getCol(), $point->getChar());
    }

    private function generateMap()
    {
        for ($i = 0; $i < $this->height; ++$i) {
            $this->map->append(array_fill(0, $this->width, ' '));
        }
    }

    private function generateOutline()
    {
        $idxZero = 0;
        $idxOne = 1;

        list(
            $widthLessOne,
            $widthLessTwo,
            $heightLessOne,
            $heightLessTwo
        ) = $this->getBorder();

        $this->updateMap($idxZero, $idxZero, Char::boxTopLeft());
        $this->updateMap($idxZero, $widthLessOne, Char::boxTopRight());

        $this->generateHLine($idxZero, $idxOne, $widthLessTwo, Char::boxHorizontal());
        $this->generateHLine($heightLessOne, $idxOne, $widthLessTwo, Char::boxHorizontal());

        $this->generateVLine($idxZero, $idxOne, $heightLessTwo, Char::boxVertical());
        $this->generateVLine($widthLessOne, $idxOne, $heightLessTwo, Char::boxVertical());

        $this->updateMap($heightLessOne, $idxZero, Char::boxBottomLeft());
        $this->updateMap($heightLessOne, $widthLessOne, Char::boxBottomRight());
    }

    /**
     * @param int    $row
     * @param int    $start
     * @param int    $cols
     * @param string $char
     */
    private function generateHLine(int $row, int $start, int $cols, string $char)
    {
        for ($i = 0; $i < $cols; ++$i) {
            $this->updateMap($row, $start + $i, $char);
        }
    }

    /**
     * @param int    $col
     * @param int    $start
     * @param int    $rows
     * @param string $char
     */
    private function generateVLine(int $col, int $start, int $rows, string $char)
    {
        for ($i = 0; $i < $rows; ++$i) {
            $this->updateMap($start + $i, $col, $char);
        }
    }

    /**
     * @param int    $row
     * @param int    $start
     * @param int    $cols
     * @param string $char
     */
    private function checkHLineCollision(int $row, int $start, int $cols, Point $point)
    {
        for ($i = 0; $i < $cols; ++$i) {
            $col = $start + $i;
            if ($row == $point->getRow() && $col == $point->getCol()) {
                throw GameException::snakeCollision();
            }
        }
    }

    private function checkVLineCollision(int $col, int $start, int $rows, Point $point)
    {
        for ($i = 0; $i < $rows; ++$i) {
            $row = $start + $i;
            if ($row == $point->getRow() && $col == $point->getCol()) {
                throw GameException::snakeCollision();
            }
        }
    }
}
