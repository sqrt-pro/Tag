<?php

namespace SQRT\Tag;

use SQRT\Tag;
use SQRT\TagWithOptions;

class CheckboxListing extends TagWithOptions
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
    $ch = new Checkbox($this->getName(), $real_value, $value, $this->checkSelectedValue($real_value));
    $ch->setIsArrayValue(true);

    return $ch;
  }

  /** Создание тега для вложенных опций */
  protected function renderOptionsTmpl(Tag $tag)
  {
    return sprintf(
      $this->getOptionsTmpl(),
      $tag->toHTML(),
      $tag instanceof Checkbox ? $tag->getDisplayValue() : $tag->getValue()
    );
  }
}