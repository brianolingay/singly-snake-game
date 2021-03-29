<?php

declare(strict_types=1);

namespace App\World;

interface Cursor
{
  const START = "\033[0;0f";
  const HIDE = "\033[?25l";
  const SHOW = "\033[?25h\033[?0c";
}
