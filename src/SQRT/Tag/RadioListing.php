<?php

namespace SQRT\Tag;

use SQRT\Tag;
use SQRT\TagWithOptions;

class RadioListing extends TagWithOptions
{
  function __construct($name, array $options, $selected = null)
  {
    $this->options  = $options;
    $this->selected = $selected;

    $this->setName($name);
    $this->setOptionsTmpl("<label>%s %s</label>\n");
  }

  public function toHTML()
  {
    return $this->getValue();
  }

  /** Создание тега для вложенных опций */
  protected function makeOptionTag($value, $real_value)
  {
    return new Radio($this->getName(), $real_value, $value, $this->checkSelectedValue($real_value));
  }

  /** Создание тега для вложенных опций */
  protected function renderOptionsTmpl(Radio $tag)
  {
    return sprintf($this->getOptionsTmpl(), $tag->toHTML(), $tag->getDisplayValue());
  }
}