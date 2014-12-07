<?php

namespace SQRT\Tag;

use SQRT\Tag;

class Radio extends Tag
{
  protected $display_value;

  function __construct($name, $value, $display_value = null, $selected = null)
  {
    $this->tag   = 'input';
    $this->short = true;

    $this->setName($name);
    $this->setValue($value);
    $this->display_value = $display_value;
    if ($selected) {
      $this->setSelected(true);
    }
    $this->set('type', 'radio');
  }

  protected function preProcessAttr($attr)
  {
    if ($this->getSelected()) {
      $attr['checked'] = 'checked';
    }

    return $attr;
  }

  public function getDisplayValue()
  {
    return $this->display_value ?: $this->getValue();
  }

  public function setDisplayValue($display_value)
  {
    $this->display_value = $display_value;

    return $this;
  }
}