<?php

function deepClone($object)
{
  return unserialize(serialize($object));
}

function computeLevel($score)
{
  $scorePerLevel = 10;
  $levelToAdd = $score / $scorePerLevel;

  return floor($levelToAdd);
}
