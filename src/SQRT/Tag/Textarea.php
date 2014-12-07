<?php

namespace SQRT\Tag;

use SQRT\Tag;

class Textarea extends Tag
{
  function __construct($name, $value = null, $attr = null)
  {
    $this->tag = 'textarea';

    $this->setValue($value);
    $this->setAttr($attr);
    $this->setName($name);
  }

  public function getValue()
  {
    return htmlspecialchars($this->value);
  }
}