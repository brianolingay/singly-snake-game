<?php

function deepClone($object)
{
  return unserialize(serialize($object));
}
