<?php

declare(strict_types=1);

namespace App\LinkedList;

class Node
{
  /** @var array|object */
  private $data;
  private $next;

  public function __construct()
  {
    $this->data = [];
    $this->next = null;
  }

  public function setData($data): void
  {
    $this->data = $data;
  }

  public function getData()
  {
    return $this->data;
  }

  public function setNext($next): void
  {
    $this->next = $next;
  }

  public function getNext()
  {
    return $this->next;
  }
}
