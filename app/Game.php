<?php

declare(strict_types=1);

namespace App;

use App\Exception\GameException;
use App\World\Land;
use App\World\Drawer;

class Game
{
    /**
     * @var Terminal
     */
    private $terminal;

    /**
     * @var Land
     */
    private $land;

    /**
     * @var Drawer
     */
    private $drawer;

    /**
     * @var int
     */
    private $speed = 50000;

    public function __construct()
    {
        $this->terminal = new Terminal();
        $this->land = new Land(intval($this->terminal->getWidth()), intval($this->terminal->getHeight()) - 3);
        $this->drawer = new Drawer(STDOUT);

        $this->drawWorld();
    }

    public function run()
    {
        try {
            while (true) {
                $this->reNewLandAndTerminal();
                $input = $this->terminal->getChar();
                $this->land->moveSnake($input);
                $this->drawWorld();
                usleep($this->getSpeed());
            }
        } catch (GameException $exception) {
            $this->gameOver();
        }
    }

    private function reNewLandAndTerminal()
    {
        $terminal = new Terminal();
        if (
            $terminal->getWidth() != $this->terminal->getWidth() &&
            $terminal->getHeight() != $this->terminal->getHeight()
        ) {
            $this->terminal = $terminal;
            $this->land = new Land(intval($terminal->getWidth()), intval($terminal->getHeight()) - 2);
        }
    }

    public function gameOver()
    {
        $this->land->writeGameOver();
        $this->drawWorld();
    }

    private function drawWorld()
    {
        $this->drawer->draw($this->land);
    }

    private function getSpeed()
    {
        $reduction = 10000;
        $fastest = 1000;
        $level = computeLevel($this->land->showScore());

        if ($level > 0) {
            $totalReduction = $reduction * $level;
            $newSpeed = $this->speed - $totalReduction;

            if ($newSpeed < $fastest) {
                return $fastest;
            }

            return intval($newSpeed);
        }

        return $this->speed;
    }
}
