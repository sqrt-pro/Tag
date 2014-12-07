<?php

namespace SQRT\Tag;

use SQRT\TagWithOptions;

class Select extends TagWithOptions
{
  function __construct($name, array $options, $selected = null, $attr = null)
  {
    parent::__construct('select', $options, $selected, $attr);

    $this->setName($name);
  }

  /** Создание тега для вложенных опций */
  protected function makeOptionTag($value, $real_value)
  {
    return new Option($value, $real_value, $this->checkSelectedValue($real_value));
  }
}