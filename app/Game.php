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

    public function __construct()
    {
        $this->terminal = new Terminal();
        $this->land = new Land(intval($this->terminal->getWidth()), intval($this->terminal->getHeight()) - 2);
        $this->drawer = new Drawer(STDOUT);

        $this->drawWorld();
    }

    public function run()
    {
        try {
            while (true) {
                $input = $this->terminal->getChar();
                $this->land->moveSnake($input);
                $this->drawWorld();
                usleep(60000);
            }
        } catch (GameException $exception) {
            $this->gameOver();
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
}
