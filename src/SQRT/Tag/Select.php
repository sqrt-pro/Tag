<?php

namespace SQRT\Tag;

use SQRT\Tag;
use SQRT\TagWithOptions;

class Select extends TagWithOptions
{
  protected $placeholder;

  function __construct($name, array $options, $selected = null, $attr = null, $placeholder = null)
  {
    parent::__construct('select', $options, $selected, $attr);

    $this->setPlaceholder($placeholder);
    $this->setName($name);
  }

  /** Опция без значения */
  public function getPlaceholder()
  {
    return $this->placeholder;
  }

  /** @return static */
  public function setPlaceholder($placeholder)
  {
    $this->placeholder = $placeholder;

    return $this;
  }

  /** @return Option[] */
  public function getOptionsTags()
  {
    $arr = parent::getOptionsTags() ?: array();
    if ($pl = $this->getPlaceholder()) {
      array_unshift($arr, $this->makeOptionTag($pl, ''));
    }

    return $arr;
  }

  /** Создание тега для вложенных опций */
  protected function makeOptionTag($value, $real_value)
  {
    return new Option($value, $real_value, $this->checkSelectedValue($real_value));
  }
}