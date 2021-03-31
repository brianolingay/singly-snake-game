<?php

declare(strict_types=1);

namespace App\World;

class Drawer
{
    /**
     * @var string
     */
    private $stream;

    /**
     * @param resource $stream
     */
    public function __construct($stream)
    {
        $this->stream = $stream;
    }

    /**
     * @param Land $land
     */
    public function draw(Land $land)
    {
        $this->hideCursor();
        $this->moveCursorToStart();

        $this->newLine();

        foreach ($land->getMap() as $line) {
            foreach ($line as $char) {
                fwrite($this->stream, $char);
            }
            $this->newLine();
        }

        $this->displayScoreAndLevel($land->showScore());
        $this->newLine();
        $this->showCursor();
    }

    private function newLine()
    {
        fwrite($this->stream, PHP_EOL);
    }

    private function moveCursorToStart()
    {
        fwrite($this->stream, Cursor::START);
    }

    private function hideCursor()
    {
        fwrite($this->stream, Cursor::HIDE);
    }

    private function showCursor()
    {
        fwrite($this->stream, Cursor::SHOW);
    }

    private function displayScoreAndLevel($score)
    {
        $level = 1;
        $scorePerLevel = 10;
        $levelToAdd = $score / $scorePerLevel;

        $level += floor($levelToAdd);

        fwrite($this->stream, "Score: {$score}, Level: {$level}");
    }
}
