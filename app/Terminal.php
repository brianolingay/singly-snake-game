<?php

declare (strict_types = 1);

namespace App;

class Terminal
{
    /**
     * @var int
     */
    private $width;

    /**
     * @var
     */
    private $height;

    public function __construct()
    {
        $this->width = intval(`tput cols`);
        $this->height = intval(`tput lines`);
        stream_set_blocking(STDIN, false);
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return string
     */
    public function getChar(): string
    {
        readline_callback_handler_install('', function () {});
        $char = stream_get_contents(STDIN, 1);
        readline_callback_handler_remove();

        return $char;
    }
}
