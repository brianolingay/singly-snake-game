<?php

declare(strict_types=1);

namespace App\LinkedList;

class Singly
{
  private $head;

  public function __construct()
  {
    $this->head = null;
  }

  /** Append */
  public function append($data): void
  {

    $newNode = new Node();
    $newNode->setData($data);

    if ($this->head) {
      $currentNode = $this->head;
      while ($currentNode->getNext() != null) {
        $currentNode = $currentNode->getNext();
      }
      $currentNode->setNext($newNode);
    } else {
      $this->head = $newNode;
    }
  }

  public function get($idx)
  {
    if ($this->head) {
      $currentNode = $this->head;
      $ctr = 0;
      while (true) {
        if ($ctr === $idx) {
          return $currentNode->getData();
        }
        $currentNode = $currentNode->getNext();
        $ctr++;
      }
    }

    return null;
  }

  public function last()
  {
    if ($this->head) {
      $currentNode = $this->head;
      $idx = count($this->getList()) - 1;
      $ctr = 0;
      while (true) {
        if ($ctr === $idx) {
          return $currentNode->getData();
        }

        $currentNode = $currentNode->getNext();
        $ctr++;
      }
    }

    return null;
  }

  public function updateSpecificNode($idx, $value): bool
  {
    if ($this->head) {
      $currentNode = $this->head;
      $ctr = 0;
      while (true) {
        if ($ctr === $idx) {
          $currentNode->setData($value);
          return true;
        }
        $currentNode = $currentNode->getNext();
        $ctr++;
      }
    }

    return false;
  }

  /** prepend */
  public function prepend($data): void
  {
    if ($this->head) {
      $newNode = new Node();
      $newNode->setData($data);
      $newNode->setNext($this->head);
      $this->head = $newNode;
    } else {
      $newNode = new Node();
      $newNode->setData($data);
      $this->head = $newNode;
    }
  }

  public function delete($idx): bool
  {

    if ($this->head) {
      $currentNode = $this->head;
      $prevNode = null;
      $ctr = 0;
      while (true) {
        if ($ctr === $idx) {
          if ($prevNode) {
            $prevNode->setNext($currentNode->getNext());
            unset($currentNode);
          } else {
            $this->head = $currentNode->getNext();
            unset($currentNode);
          }

          return true;
        }
        $prevNode = $currentNode;
        $currentNode = $currentNode->getNext();
        $ctr++;
      }
    }

    return false;
  }

  public function deleteLast(): bool
  {

    if ($this->head) {
      $currentNode = $this->head;
      $prevNode = null;
      $idx = count($this->getList()) - 1;
      $ctr = 0;
      while (true) {
        if ($ctr === $idx) {
          if ($prevNode) {
            $prevNode->setNext($currentNode->getNext());
            unset($currentNode);
          } else {
            $this->head = $currentNode->getNext();
            unset($currentNode);
          }

          return true;
        }
        $prevNode = $currentNode;
        $currentNode = $currentNode->getNext();
        $ctr++;
      }
    }

    return false;
  }

  public function getList(): array
  {
    $list = [];
    $currentNode = $this->head;
    while ($currentNode != null) {
      if ($currentNode != null) {
        array_push($list, $currentNode->getData());
        $currentNode = $currentNode->getNext();
      }
    }

    return $list;
  }
}
