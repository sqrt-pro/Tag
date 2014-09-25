<?php

namespace SQRT\Tag;

use SQRT\Tag;

class Input extends Tag
{
  function __construct($name, $value = null, $attr = null, $type = null)
  {
    $this->tag   = 'input';
    $this->short = true;

    $this->setValue($value);
    $this->setAttr($attr);
    $this->setName($name);
    $this->setType($type ?: 'text');
  }

  public function setType($type)
  {
    return $this->set('type', $type);
  }

  public function getType()
  {
    return $this->get('type');
  }
}